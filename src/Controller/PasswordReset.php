<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordReset extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/registration/password-reset", name="password_reset", methods={"GET","POST"})
     */
    public function Reset(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            if (empty($password)) {
                return $this->render('passwordReset.html.twig', [
                    'error' => 'Пароль не может быть пустым',
                    'email' => $email,
                ]);
            }

            $userRepository = $this->entityManager->getRepository(Users::class);
            $user = $userRepository->findOneBy(['email' => $email]);

            if ($user !== null) {
                $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);
                $this->entityManager->flush();

                return $this->render('vhod.html.twig',[
                    'succes' => 'Ваш пароль успешно сменён!'
                ]);
            } else {
                return $this->render('passwordReset.html.twig', [
                    'error' => 'Данной почты не существует',
                    'email' => $email,
                    'password' => $password,
                ]);
            }
        }

        return $this->render('passwordReset.html.twig');
    }
}
