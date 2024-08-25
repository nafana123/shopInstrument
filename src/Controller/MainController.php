<?php

namespace App\Controller;

use App\Entity\PopularBrend;
use App\Entity\Product;
use App\Entity\Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="mainpage")
     */
    public function mainpage(Request $request, EntityManagerInterface $entityManager): Response
    {
        $types = $entityManager->getRepository(Type::class)->findAll();
        $imgs = $entityManager->getRepository(PopularBrend::class)->findAll();
        $popularProduct = $entityManager->getRepository(Product::class)->findBy([], ['amount' => 'DESC'], 4);

        return $this->render('base.html.twig', [
            'types' => $types,
            'popularProduct' => $popularProduct,
            'imgs' => $imgs,
        ]);
    }

}
