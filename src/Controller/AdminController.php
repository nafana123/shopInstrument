<?php

namespace App\Controller;

use App\Repository\ChecksRepository;
use App\Repository\InfoProductRepository;
use App\Repository\UsersRepository;
use App\Services\CookieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Tools\Pagination\Paginator;



class AdminController extends AbstractController
{
    private UsersRepository $usersRepository;

    private InfoProductRepository $infoProductRepository;

    private ChecksRepository $checksRepository;



    public function __construct(UsersRepository $usersRepository, InfoProductRepository $infoProductRepository, ChecksRepository $checksRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->infoProductRepository = $infoProductRepository;
        $this->checksRepository = $checksRepository;
    }
    /**
     * @Route("/admin", name="admin", methods={"GET","POST"})
     */
public function index(){
    return $this->render('admin/admin.html.twig');
}

    /**
     * @Route("/admin-users", name="full_users", methods={"GET","POST"})
     */

    public function fullUsers(Request $request)
    {
        $page = $request->query->getInt('page', 1);
        $limit = 20;

        $query = $this->usersRepository->createQueryBuilder('u')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery();

        $paginator = new Paginator($query);

        return $this->render('admin/fullUsers.html.twig', [
            'users' => $paginator,
            'currentPage' => $page,
            'totalPages' => ceil(count($paginator) / $limit),
        ]);
    }

    /**
     * @Route("/admin/{id}/users-orders", name="user_orders", methods={"GET","POST"})
     */
    public function UserOrders(Request $request, $id)
    {
        $user = $this->usersRepository->find($id);
        $checks =  $this->checksRepository->findBy(['id_user' => $id]);
        return $this->render('admin/UserOrders.html.twig', [
            'user' => $user,
            'checks' => $checks,
        ]);
    }
}