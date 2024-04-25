<?php

namespace App\Controller\katalog;

use App\Entity\Images;
use App\Entity\Product;
use App\Services\CookieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InfoController extends AbstractController
{
    /**
     * @Route("/{typeId}/{name}/{id}", name="info_product")
     */
    public function mainpage($typeId, Request $request, CookieService $cookieService, EntityManagerInterface $entityManager)
    {
        $login = $this->getUserLogin($request, $cookieService);

        $products = $entityManager->getRepository(Product::class)->findBy(['types' => $typeId]);

        $productImages = [];
        foreach ($products as $product) {
            $productId = $product->getId();
            $images = $entityManager->getRepository(Images::class)->findBy(['id_product' => $productId]);
            $productImages[$productId] = $images;
        }

        return $this->render('katalog/infoProduct.html.twig', [
            'login' => $login,
            'products' => $products,
            'productImages' => $productImages
        ]);
    }

    private function getUserLogin(Request $request, CookieService $cookieService)
    {
        return $cookieService->getUserFromCookie($request, 'user_login');
    }
}
