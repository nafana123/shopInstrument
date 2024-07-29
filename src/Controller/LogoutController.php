<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LogoutController extends AbstractController
{


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): RedirectResponse
    {
        return $this->redirectToRoute('mainpage');
    }
}
