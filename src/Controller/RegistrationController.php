<?php

namespace App\Controller;

use App\Entity\Type;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class RegistrationController extends AbstractController
{
    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $passwordHasher;
    private TokenStorageInterface $tokenStorage;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/registration", name="registration", methods={"GET", "POST"})
     */
    public function registration(Request $request): Response
    {
        $errors = [];
        if ($request->isMethod('POST')) {
            $login = $request->request->get('login');
            $email = $request->request->get('email');
            $password = $request->request->get('password');


                $existingUser = $this->em->getRepository(Users::class)->findOneBy(['email' => $email]);
                if ($existingUser) {
                    return $this->render('registration.html.twig', [
                        'login' => $login,
                        'email' => $email,
                        'error' => 'Данная почта уже зарегистрирована',
                        'password' => $password,
                    ]);
                }
                else {
                    $user = new Users();
                    $user->setLogin($login);
                    $user->setEmail($email);
                    $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
                    $user->setPassword($hashedPassword);
                    $registrationDate = new \DateTime();
                    $user->setData($registrationDate->format('d-m-Y'));
                    $this->em->persist($user);
                    $this->em->flush();

                    $token = new UsernamePasswordToken($user, $hashedPassword,  $user->getRoles());
                    $this->tokenStorage->setToken($token);
                    $request->getSession()->set('_security_main', serialize($token));

                    return $this->redirectToRoute('mainpage');
                }
        }

        return $this->render('registration.html.twig', [
            'errors' => $errors,
        ]);
    }
}
