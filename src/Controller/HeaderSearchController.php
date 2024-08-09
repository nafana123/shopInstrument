<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;



class HeaderSearchController extends AbstractController{

    private productRepository $productRepository;
    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }


    /**
     * @Route("/search", name="search", methods={"GET"})
     */
    public function list(Request $request)
    {
        $productSearch = $request->query->get('search');
        $products = $this->productRepository->productSearch($productSearch);

        $results = [];
        foreach ($products as $product) {
            $results[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'amount' => $product->getAmount(),
                'img' => $product->getImg(),
            ];
        }

        return new JsonResponse($results);
    }

}