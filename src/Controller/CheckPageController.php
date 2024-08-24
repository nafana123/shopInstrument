<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\Checks;
use App\Entity\InfoProduct;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CheckPageController extends AbstractController
{
    private EntityManagerInterface $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/check", name="check", methods={"GET", "POST"})
     */
    public function index(Request $request)
    {
        $user = $this->getUser();
        $totalPrice = 0;


        if ($request->isMethod('POST')) {
            $basketItems = $this->entityManager->getRepository(Basket::class)->findBy(['user' => $user]);

            $orderNumber = mt_rand(100000, 999999);
            $totalPrice = 0;
            $dateTimeNow = new \DateTime();

            foreach ($basketItems as $basketItem) {
                $quantity = $basketItem->getQuantity();
                $product = $basketItem->getProduct();

                if ($product) {
                    $check = new Checks();
                    $check->setProduct($product);
                    $check->setIdUser($user->getId());
                    $check->setCount($quantity);
                    $check->setFinalPrice($product->getAmount());
                    $check->setOrderNumber($orderNumber);
                    $check->setName($product->getName());
                    $check->setImg($product->getImg());
                    $check->setDateCreated($dateTimeNow);
                    $check->setStatus(Checks::STATUS_PROCESSING);
                    $registrationDate = new \DateTime();
                    $check->setData($registrationDate->format('d-m-Y'));

                    $totalPrice += $product->getAmount() * $quantity;
                    $check->setItogPrice($totalPrice);

                    $this->entityManager->persist($check);
                }
            }

            $this->entityManager->flush();

            foreach ($basketItems as $basketItem) {
                $this->entityManager->remove($basketItem);
                $this->entityManager->flush();
            }

            return $this->redirectToRoute('check');
        }

        $checks = $this->entityManager->getRepository(Checks::class)->findBy(['id_user' => $user->getId()]);

        return $this->render('checkPage.html.twig', [
            'login' => $user->getLogin(),
            'user' => $user,
            'checks' => $checks,
            'totalPrice' => $totalPrice,
        ]);
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
