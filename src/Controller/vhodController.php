<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class vhodController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
                $login = $user->getLogin();
                return $this->redirectToRoute('registration_success', ['login' => $login]);
            } else {
                return $this->render('vhod.html.twig', [
                    'error' => 'Неверная почта или пароль'
                ]);
            }
        }
        return $this->render('vhod.html.twig');

    }
    /**
     * @Route("/registration/success/{login}", name="registration_success")
     */
    public function registrationSuccess(string $login): Response
    {
        return $this->render('base.html.twig', ['login' => $login]);
    }
}
