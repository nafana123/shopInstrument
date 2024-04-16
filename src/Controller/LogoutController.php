<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\CookieService;

class LogoutController extends AbstractController
{
    private CookieService $cookieService;

    public function __construct(CookieService $cookieService)
    {
        $this->cookieService = $cookieService;
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): RedirectResponse
    {
        // Создаем новый объект ответа
        $response = new RedirectResponse($this->generateUrl('mainpage'));

        // Удаляем куки с именем 'user_login'
        $response = $this->cookieService->removeUserCookie($response, 'user_login');

        return $response;
    }
}
