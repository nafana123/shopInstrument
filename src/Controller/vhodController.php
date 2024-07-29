<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class vhodController extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;
    private UserProviderInterface $userProvider;
    private TokenStorageInterface $tokenStorage;

    public function __construct(UserPasswordHasherInterface $passwordHasher, UserProviderInterface $userProvider, TokenStorageInterface $tokenStorage)
    {
        $this->passwordHasher = $passwordHasher;
        $this->userProvider = $userProvider;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/vhod", name="vhod", methods={"GET","POST"})
     */
    public function login(Request $request): Response
    {

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');


                $user = $this->userProvider->loadUserByIdentifier($email);

                if ($user && $this->passwordHasher->isPasswordValid($user, $password)) {
                    $token = new UsernamePasswordToken($user, $password,  $user->getRoles());
                    $this->tokenStorage->setToken($token);
                    $request->getSession()->set('_security_main', serialize($token));

                    return $this->redirectToRoute('mainpage');
                } else {
                    return $this->render('vhod.html.twig', [
                        'error' => 'Неверная почта или пароль'
                    ]);
                }
        }

        return $this->render('vhod.html.twig');
    }
}
