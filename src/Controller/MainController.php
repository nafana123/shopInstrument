<?php

namespace App\Controller;

use App\Entity\Type;
use App\Services\CookieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="mainpage")
     */
    public function mainpage(Request $request, CookieService $cookieService, EntityManagerInterface $entityManager)
    {
        $login = $this->getUserLogin($request, $cookieService);
        $types = $entityManager->getRepository(type::class)->findAll();


        return $this->render('base.html.twig', [
            'login' => $login,
            'types' => $types
        ]);
    }
    private function getUserLogin(Request $request, CookieService $cookieService)
    {
        return $cookieService->getUserFromCookie($request, 'user_login');
    }

}
