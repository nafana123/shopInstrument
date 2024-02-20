<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class aController extends AbstractController
{
    /**
     * @Route("/a", name="a")
     */
    public function a(): Response
    {
        return $this->render('a.html.twig');
    }

}