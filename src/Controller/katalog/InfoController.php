<?php

namespace App\Controller\katalog;

use App\Entity\Images;
use App\Entity\InfoProduct;
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
    public function mainpage($typeId, $id, Request $request, CookieService $cookieService, EntityManagerInterface $entityManager)
    {
        $login = $this->getUserLogin($request, $cookieService);

        $product = $entityManager->getRepository(Product::class)->findOneBy(['types' => $typeId, 'id' => $id]);

        $images = $entityManager->getRepository(Images::class)->findBy(['id_product' => $id]);
        $infoProduct = $entityManager->getRepository(InfoProduct::class)->findOneBy(['id_product' => $id]);

        $products = $entityManager->getRepository(Product::class)->findBy(['types' => $typeId]);
        $similarProducts = [];

        foreach ($products as $similarProduct) {
            if ($similarProduct->getId() != $id) {
                $similarProducts[] = $similarProduct;
            }
        }

        return $this->render('katalog/infoProduct.html.twig', [
            'login' => $login,
            'product' => $product,
            'images' => $images,
            'infoProduct' => $infoProduct,
            'products' => $similarProducts
        ]);
    }

    private function getUserLogin(Request $request, CookieService $cookieService)
    {
        return $cookieService->getUserFromCookie($request, 'user_login');
    }
}
