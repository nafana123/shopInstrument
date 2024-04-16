<?php

namespace App\Controller;

use App\Services\CookieService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="mainpage")
     */
    public function mainpage(Request $request, CookieService $cookieService)
    {
        $login = $this->getUserLogin($request, $cookieService);
        return $this->render('base.html.twig', ['login' => $login]);
    }
    private function getUserLogin(Request $request, CookieService $cookieService)
    {
        // Здесь нужно реализовать логику получения логина пользователя из кук
        return $cookieService->getUserFromCookie($request, 'user_login');
    }

}
