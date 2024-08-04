<?php

namespace App\Controller;

use App\Services\CookieService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class infoController extends AbstractController
{
    /**
     * @Route("/info", name="infopage")
     */
    public function infopage()
    {
        // Получаем логин пользователя из кук

        return $this->render('infoCompany.html.twig');
    }

}
