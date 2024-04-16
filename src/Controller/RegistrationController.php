<?php

namespace App\Controller;

use App\Entity\Users;
use App\Services\CookieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private EntityManagerInterface $em;

    private CookieService $cookieService;

    public function __construct(EntityManagerInterface $em, CookieService $cookieService)
    {
        $this->em = $em;
        $this->cookieService = $cookieService;

    }

    /**
     * @Route("/registration", name="registration", methods={"GET", "POST"})
     */
    public function registration(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $login = $request->request->get('login');
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            $existingUser = $this->em->getRepository(Users::class)->findOneBy(['email' => $email]);
            if ($existingUser !== null) {
                return $this->render('registration.html.twig', [
                    'error' => 'Данная почта уже зарегистрирована',
                ]);
            }

            if ($login !== null && $email !== null && $password !== null) {
                $user = new Users();
                $user->setLogin($login);
                $user->setEmail($email);
                $user->setPassword($password);

                $this->em->persist($user);
                $this->em->flush();

                // Передача логина пользователя в шаблон
                $response = $this->redirectToRoute('registration_success', ['login' => $login]);
                $response = $this->cookieService->setUserCookie($response, 'user_login', $login);
                return $response;
            }
        }

        return $this->render('registration.html.twig');
    }

    /**
     * @Route("/registration/success/{login}", name="registration_success")
     */
    public function registrationSuccess(string $login): Response
    {
        return $this->render('base.html.twig', ['login' => $login]);
    }
}
