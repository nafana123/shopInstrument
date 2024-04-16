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
    public function infopage(Request $request, CookieService $cookieService)
    {
        // Получаем логин пользователя из кук
        $login = $this->getUserLogin($request, $cookieService);

        return $this->render('infoCompany.html.twig', ['login' => $login]);
    }

    private function getUserLogin(Request $request, CookieService $cookieService)
    {
        // Здесь нужно реализовать логику получения логина пользователя из кук
        return $cookieService->getUserFromCookie($request, 'user_login');
    }
}
