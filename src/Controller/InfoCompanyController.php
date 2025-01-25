<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InfoCompanyController extends AbstractController
{
    /**
     * @Route("/info", name="infopage")
     */
    public function infopage()
    {
        return $this->render('infoCompany.html.twig');
    }

}
