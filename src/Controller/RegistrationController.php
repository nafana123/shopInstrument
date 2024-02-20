<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/registration", name="registration", methods={"GET","POST"})
     */
    public function registr(Request $request): Response
    {
        $login = $request->request->get('login');
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        if ($login === null || $email === null || $password === null) {
            return $this->render('registration.html.twig');
        }

        $user = new Users();
        $user->setLogin($login);
        $user->setEmail($email);
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('registration_success', ['user_email' => $email]);
    }

    /**
     * @Route("/registration/success", name="registration_success")
     */
    public function registrationSuccess(Request $request): Response
    {
        $user_email = $request->query->get('user_email');
        return $this->render('base.html.twig', ['user_email' => $user_email]);
    }
}
