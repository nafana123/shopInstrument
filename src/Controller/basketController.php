<?php

namespace App\Controller;

use App\Entity\InfoProduct;
use App\Services\CookieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class basketController extends AbstractController
{
    /**
     * @Route("/basket", name="basket", methods={"GET", "POST"})
     */
    public function list(Request $request, EntityManagerInterface $entityManager, CookieService $cookieService)
    {
        $login = $this->getUserLogin($request, $cookieService);


        $infoProduct = $entityManager->getRepository(InfoProduct::class);
            $cookieValue = $request->cookies->get('cart');
            $cartItemsPairs = str_getcsv($cookieValue, ',');
            $cartItems = [];

            foreach ($cartItemsPairs as $pair) {
                $item = explode(':', $pair);
                $itemId = $item[0] ?? null;
                $quantity = $item[1] ?? null;

                $product = $infoProduct->findOneBy(['id_product' => $itemId]);

                if ($product) {
                    $cartItems[] = [
                        'id' => $product->getIdProduct(),
                        'name' => $product->getName(),
                        'price' => $product->getPrice(),
                        'img' => $product->getImg(),
                        'quantity' => $quantity,
                    ];
                }
            }

            return $this->render('basket.html.twig', [
                'login' => $login,
                'cartItems' => $cartItems ?? null,
            ]);
        }

    private function getUserLogin(Request $request, CookieService $cookieService)
    {
        return $cookieService->getUserFromCookie($request, 'user_login');
    }


}
