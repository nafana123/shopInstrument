<?php

namespace App\Controller\katalog;

use App\Entity\Basket;
use App\Entity\Images;
use App\Entity\InfoProduct;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InfoController extends AbstractController
{
    /**
 * @Route("/{typeId}/{name}/{id}", name="info_product")
 */
    public function mainpage($typeId, $id, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();

        $product = $entityManager->getRepository(Product::class)->findOneBy(['types' => $typeId, 'id' => $id]);

        $images = $entityManager->getRepository(Images::class)->findBy(['id_product' => $id]);
        $infoProduct = $entityManager->getRepository(InfoProduct::class)->findOneBy(['id_product' => $id]);

        $products = $entityManager->getRepository(Product::class)->findBy(['types' => $typeId]);
        $similarProducts = [];

        $infoProd = $entityManager->getRepository(InfoProduct::class)->findBy([], ['sale' => 'DESC'], 4);

        $basketItems = $entityManager->getRepository(Basket::class)->findBy(['user' => $user]);
        $basketProductIds = array_map(fn($item) => $item->getProduct()->getId(), $basketItems);


        foreach ($products as $similarProduct) {
            if ($similarProduct->getId() != $id) {
                $similarProducts[] = $similarProduct;
            }
        }

        return $this->render('katalog/infoProduct.html.twig', [
            'product' => $product,
            'images' => $images,
            'infoProd' => $infoProd,
            'infoProduct' => $infoProduct,
            'products' => $similarProducts,
            'basketProductIds' => $basketProductIds,
        ]);
    }
}
