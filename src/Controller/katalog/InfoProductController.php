<?php

namespace App\Controller\katalog;

use App\Entity\Basket;
use App\Entity\Images;
use App\Entity\ProductCharacteristics;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;

class InfoProductController extends AbstractController
{
    /**
 * @Route("/{typeId}/{name}/{id}", name="info_product")
 */
    public function mainpage($typeId, $id, ProductRepository $productRepository, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();

        $product = $productRepository->findProductById($id);

        $productCharacteristics = $entityManager->getRepository(ProductCharacteristics::class)->findBy(['product' => $product]);
        $images = $entityManager->getRepository(Images::class)->findBy(['id_product' => $id]);

        $similarProducts = $productRepository->findSimilarProducts($typeId, $id);

        $popularProducts = $productRepository->findPopularProducts();

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
