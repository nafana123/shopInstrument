<?php

namespace App\Controller\katalog;

use App\Entity\Basket;
use App\Entity\Images;
use App\Entity\InfoProduct;
use App\Entity\Product;
use App\Entity\ProductCharacteristics;
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

        $product = $entityManager->getRepository(Product::class)->find($id);

        $productCharacteristics = $entityManager->getRepository(ProductCharacteristics::class)->findBy(['product' => $product]);
        $images = $entityManager->getRepository(Images::class)->findBy(['id_product' => $id]);

        $products = $entityManager->getRepository(Product::class)->findBy(['types' => $typeId]);
        $similarProducts = array_filter($products, fn($similarProduct) => $similarProduct->getId() !== $product->getId());

        $popularProducts = $entityManager->getRepository(Product::class)->findBy([], ['amount' => 'DESC'], 4);

        $basketItems = $entityManager->getRepository(Basket::class)->findBy(['user' => $user]);
        $basketProductIds = array_map(fn($item) => $item->getProduct()->getId(), $basketItems);

        return $this->render('katalog/infoProduct.html.twig', [
            'product' => $product,
            'images' => $images,
            'popularProducts' => $popularProducts,
            'products' => $similarProducts,
            'basketProductIds' => $basketProductIds,
            'productCharacteristics' => $productCharacteristics,
        ]);
    }

}
