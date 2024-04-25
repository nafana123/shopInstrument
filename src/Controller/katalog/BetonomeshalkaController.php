<?php

namespace App\Controller\katalog;

use App\Entity\Betonomeshalka;
use App\Services\CookieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BetonomeshalkaController extends AbstractController
{
    /**
     * @Route("/katalog/betonomeshalka", name="betonomeshalka")
     */
    public function list(Request $request, CookieService $cookieService, EntityManagerInterface $entityManager)
    {
        $login = $this->getUserLogin($request, $cookieService);

        $betonomeshalkas = $entityManager->getRepository(Betonomeshalka::class)->findAll();

        // Отображаем шаблон с данными
        return $this->render('katalog/betonomeshalka.html.twig', [
            'login' => $login,
            'betonomeshalkas' => $betonomeshalkas,
        ]);
    }

    private function getUserLogin(Request $request, CookieService $cookieService)
    {
        return $cookieService->getUserFromCookie($request, 'user_login');
    }
}
