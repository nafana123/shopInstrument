<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private EntityManagerInterface $em;

    private ProductRepository $productRepository;

    public function __construct(EntityManagerInterface $em,ProductRepository $productRepository)
    {
        $this->em = $em;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/{name}/{typeId}", name="product")
     */
    public function mainpage($typeId, Request $request, EntityManagerInterface $entityManager)
    {

        $products = $entityManager->getRepository(Product::class)->findBy(['types' => $typeId]);

        return $this->render('katalog/product.html.twig', [
            'products' => $products,
            'typeId' => $typeId

        ]);
    }


    /**
     * @Route("/filter", name="form_filteras", methods={"GET", "POST"})
     */
    public function filters(Request $request)
    {
        $queryParams = $request->query->all();

        $typeId = $request->query->get('typeId');
        $searchName = $request->query->get('search');
        $priceFrom = $request->query->get('price_from');
        $priceTo = $request->query->get('price_to');
        $sortPrice = $request->query->get('sort_price');

        $discounts = isset($queryParams['discount']) ? $queryParams['discount'] : [];

        $products = $this->productRepository->findAllSearchName($searchName, $typeId, $priceFrom, $priceTo, $sortPrice, $discounts);

        return $this->render('katalog/product.html.twig', [
            'products' => $products,
            'typeId' => $typeId,
            'discounts' => $discounts,
        ]);
    }



}
