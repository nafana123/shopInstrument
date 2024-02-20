<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LogoutController extends AbstractController
{
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): Response
    {
        // Пользователь выходит из системы - здесь можно выполнить необходимые действия

        // Перенаправляем пользователя на главную страницу или куда-либо еще
        return $this->render('base.html.twig');
    }
}
