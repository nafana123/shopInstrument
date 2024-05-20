<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\PopularBrend;
use App\Entity\Type;
use App\Entity\InfoProduct;
use App\Services\CookieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="mainpage")
     */
    public function mainpage(Request $request, CookieService $cookieService, EntityManagerInterface $entityManager): Response
    {
        $login = $this->getUserLogin($request, $cookieService);
        $types = $entityManager->getRepository(Type::class)->findAll();
        $imgs = $entityManager->getRepository(PopularBrend::class)->findAll();

        $infoProduct = $entityManager->getRepository(InfoProduct::class)->findBy([], ['sale' => 'DESC'], 4);

        return $this->render('base.html.twig', [
            'login' => $login,
            'types' => $types,
            'infoProduct' => $infoProduct,
            'imgs' => $imgs,
        ]);
    }

    private function getUserLogin(Request $request, CookieService $cookieService)
    {
        return $cookieService->getUserFromCookie($request, 'user_login');
    }
}
