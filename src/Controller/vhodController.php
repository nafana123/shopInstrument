<?php

namespace App\Controller;

use App\Entity\Users;
use App\Services\CookieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class vhodController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private CookieService $cookieService;

    public function __construct(EntityManagerInterface $entityManager, CookieService $cookieService)
    {
        $this->entityManager = $entityManager;
        $this->cookieService = $cookieService;
    }

    /**
     * @Route("/vhod", name="vhod", methods={"GET","POST"})
     */
    public function login(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            $userRepository = $this->entityManager->getRepository(Users::class);

            $user = $userRepository->findOneBy(['email' => $email, 'password' => $password]);

            if ($user !== null) {
                if($user->getLogin() === 'admin' && $user->getPassword() === $password){
                    $login = $user->getLogin();
                    $response = $this->redirectToRoute('admin', ['login' => $login]);
                    return $response;

                }
                $login = $user->getLogin();
                $response = $this->redirectToRoute('registration_success', ['login' => $login]);
                $response = $this->cookieService->setUserCookie($response, 'user_login', $login);
                return $response;
            } else {
                return $this->render('vhod.html.twig', [
                    'error' => 'Неверная почта или пароль'
                ]);
            }
        }
        return $this->render('vhod.html.twig');

    }
    /**
     * @Route("/", name="registration_success")
     */
    public function registrationSuccess(string $login): Response
    {
        return $this->render('base.html.twig', ['login' => $login]);
    }
}
