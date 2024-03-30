<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }
    /**
     * @Route("/registration", name="registration", methods={"GET","POST"})
     */
    public function registration(Request $request): Response
    {
        $login = $request->request->get('login');
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        if ($login !== null && $email !== null && $password !== null) {
            $user = new Users();
            $user->setLogin($login);
            $user->setEmail($email);
            $user->setPassword($password);

            $this->em->persist($user);
            $this->em->flush();

            return $this->render('base.html.twig');


        } else {

            return $this->render('registration.html.twig');
        }

    }

}
