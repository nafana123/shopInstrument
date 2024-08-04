<?php

namespace App\Controller;

use App\Entity\Checks;
use App\Entity\InfoProduct;
use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Services\CookieService;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class CheckPageController extends AbstractController
{
    private UsersRepository $usersRepository;
    private EntityManagerInterface $entityManager;


    public function __construct(UsersRepository $usersRepository,
                                EntityManagerInterface $entityManager,

    )
    {
        $this->usersRepository = $usersRepository;
        $this->entityManager = $entityManager;



    }

    /**
     * @Route("/check", name="check", methods={"GET", "POST"})
     */
    public function index(Request $request)
    {
        $user = $this->getUser();

        $infoProductRepository = $this->entityManager->getRepository(InfoProduct::class);
        $cookieValue = $request->cookies->get('cart');

        $orderNumber = mt_rand(100000, 999999);
        $totalPrice = 0;

        if ($cookieValue) {
            $cartItemsPairs = str_getcsv($cookieValue, ',');
            $dateTimeNow = new \DateTime();

            foreach ($cartItemsPairs as $pair) {
                $item = explode(':', $pair);
                $itemId = $item[0] ?? null;
                $quantity = $item[1] ?? null;

                $product = $infoProductRepository->findOneBy(['id_product' => $itemId]);

                if ($product) {
                    $check = new Checks();
                    $check->setIdProducts($product->getIdProduct());
                    $check->setIdUser($user->getId());
                    $check->setCount($quantity);
                    $check->setFinalPrice($product->getPrice());
                    $check->setOrderNumber($orderNumber);
                    $check->setName($product->getName());
                    $check->setImg($product->getImg());
                    $check->setDateCreated($dateTimeNow);
                    $check->setStatus(Checks::STATUS_PROCESSING);
                    $registrationDate = new \DateTime();
                    $check->setData($registrationDate->format('d-m-Y'));


                    $totalPrice += $product->getPrice() * $quantity;
                    $check->setItogPrice($totalPrice);


                    $this->entityManager->persist($check);
                }
            }
        }

        $this->entityManager->flush();

        $checks = $this->entityManager->getRepository(Checks::class)->findBy(['id_user' => $user->getId()]);


        $response = $this->render('checkPage.html.twig', [
            'login' => $user->getLogin(),
            'user' => $user,
            'checks' => $checks,
            'totalPrice' => $totalPrice,
        ]);

        $response->headers->clearCookie('cart');

        return $response;
    }
    /**
     * @Route("/download-pdf/{orderId}", name="download_pdf")
     */
    public function generatePdfResponse(Request $request, int $orderId): Response
    {
        $user = $this->getUser();

        $checks = $this->entityManager->getRepository(Checks::class)->findBy(['id_user' => $user->getId(), 'order_number' => $orderId]);

        if (count($checks) === 0) {
            return new Response('Заказ не найден', Response::HTTP_NOT_FOUND);
        }

        $totalPrice = 0;
        foreach ($checks as $check) {
            $totalPrice += $check->getFinalPrice() * $check->getCount();
        }

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);

        $html = $this->renderView('checkPagePdf.html.twig', [
            'user' => $user,
            'check' => $checks,
            'totalPrice' => $totalPrice,
        ]);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $pdfOutput = $dompdf->output();

        $response = new Response($pdfOutput);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment; filename="order_'.$orderId.'.pdf"');

        return $response;
    }

    /**
     * @Route("/update-user-name", name="update_user_name", methods={"POST"})
     */
    public function updateUserName(Request $request): Response
    {
        $newName = $request->request->get('newName');

        if (!$this->getUser() instanceof UserInterface) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();
        $user->setLogin($newName);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('check');
    }
}
