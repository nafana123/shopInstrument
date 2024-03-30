<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class vhodController extends AbstractController
{
    /**
     * @Route("/vhod", name="vhod", methods={"GET","POST"})
     */
    public function registration(Request $request): Response
    {
            return $this->render('vhod.html.twig');


    }
}