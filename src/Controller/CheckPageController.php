<?php

namespace App\Controller;

use App\Entity\Checks;
use App\Entity\InfoProduct;
use App\Repository\UsersRepository;
use App\Services\CookieService;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckPageController extends AbstractController
{
    private UsersRepository $usersRepository;
    private EntityManagerInterface $entityManager;
    private CookieService $cookieService;

    public function __construct(UsersRepository $usersRepository, EntityManagerInterface $entityManager, CookieService $cookieService)
    {
        $this->usersRepository = $usersRepository;
        $this->entityManager = $entityManager;
        $this->cookieService = $cookieService;
    }

    /**
     * @Route("/check", name="check", methods={"GET", "POST"})
     */
    public function index(Request $request)
    {
        $login = $this->getUserLogin($request);

        $user = $this->usersRepository->findOneBy(['login' => $login]);

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
            'login' => $login,
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
        $login = $this->getUserLogin($request);
        $user = $this->usersRepository->findOneBy(['login' => $login]);

        $checks = $this->entityManager->getRepository(Checks::class)->findBy(['id_user' => $user->getId(), 'order_number' => $orderId]);

        if (count($checks) === 0) {
            return new Response('Заказ не найден', Response::HTTP_NOT_FOUND);
        }

        // Рассчитываем итоговую цену заказа
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
            'totalPrice' => $totalPrice, // Передаем общую стоимость в шаблон
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


    private function getUserLogin(Request $request)
    {
        return $this->cookieService->getUserFromCookie($request, 'user_login');
    }
}
