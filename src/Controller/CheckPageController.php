<?php

namespace App\Controller;

use App\Entity\Checks;
use App\Entity\InfoProduct;
use App\Repository\UsersRepository;
use App\Services\CookieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

                    $totalPrice += $product->getPrice() * $quantity;

                    $this->entityManager->persist($check);
                }
            }
        }

        $this->entityManager->flush();

        $checks = $this->entityManager->getRepository(Checks::class)->findBy(['id_user' => $user->getId()]);


        $response = $this->render('checkPage.html.twig', [
            'login' => $login,
            'checks' => $checks,
            'totalPrice' => $totalPrice,
        ]);

        $response->headers->clearCookie('cart');

        return $response;
    }

    private function getUserLogin(Request $request)
    {
        return $this->cookieService->getUserFromCookie($request, 'user_login');
    }
}
