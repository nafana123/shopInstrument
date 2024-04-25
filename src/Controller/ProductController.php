<?php

namespace App\Controller;

use App\Entity\Product;
use App\Services\CookieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/{name}/{typeId}", name="product")
     */
    public function mainpage($typeId, Request $request, CookieService $cookieService, EntityManagerInterface $entityManager)
    {
        $login = $this->getUserLogin($request, $cookieService);

        $products = $entityManager->getRepository(Product::class)->findBy(['types' => $typeId]);

        return $this->render('katalog/product.html.twig', [
            'login' => $login,
            'products' => $products
        ]);
    }

    private function getUserLogin(Request $request, CookieService $cookieService)
    {
        return $cookieService->getUserFromCookie($request, 'user_login');
    }
}
