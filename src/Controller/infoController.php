<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class infoController extends AbstractController
{
    /**
     * @Route("/info", name="infopage")
     */
    public function infopage(){

        return $this->render('infoCompany.html.twig');
    }
}