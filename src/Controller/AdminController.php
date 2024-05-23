<?php

namespace App\Controller;

use App\Entity\Checks;
use App\Entity\Images;
use App\Entity\InfoProduct;
use App\Entity\PopularBrend;
use App\Entity\Product;
use App\Entity\Type;
use App\Repository\ChecksRepository;
use App\Repository\InfoProductRepository;
use App\Repository\UsersRepository;
use App\Services\CookieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\String\Slugger\SluggerInterface;


class AdminController extends AbstractController
{
    private UsersRepository $usersRepository;

    private EntityManagerInterface $entityManager;

    private ChecksRepository $checksRepository;



    public function __construct(UsersRepository $usersRepository, InfoProductRepository $infoProductRepository, ChecksRepository $checksRepository, EntityManagerInterface $entityManager)
    {
        $this->usersRepository = $usersRepository;
        $this->infoProductRepository = $infoProductRepository;
        $this->checksRepository = $checksRepository;
        $this->entityManager = $entityManager;
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
        $totalUsers = count($paginator);

        return $this->render('admin/fullUsers.html.twig', [
            'users' => $paginator,
            'currentPage' => $page,
            'totalPages' => ceil($totalUsers / $limit),
            'totalUsers' => $totalUsers,
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
    /**
     * @Route("/admin/update-order-status/{orderNumber}/{status}", name="update_order_status", methods={"POST"})
     */
    public function updateOrderStatus($orderNumber, $status): Response
    {
        $checks = $this->checksRepository->findBy(['order_number' => $orderNumber]);

        foreach ($checks as $check) {
            $check->setStatus($status);
        }

        $this->entityManager->flush();

        $userId = $checks[0]->getIdUser();
        return $this->redirectToRoute('user_orders', ['id' => $userId]);
    }

    /**
     * @Route("/admin/order-processing", name="status_processing")
     */
    public function statusProcessing(Request $request): Response
    {
        $status = $request->query->get('status');
        $orderNumber = $request->query->get('orderNumber');

        if ($status && $orderNumber) {
            $orderNumbers = $this->checksRepository->findBy(['order_number' => $orderNumber]);

            foreach ($orderNumbers as $check) {
                $check->setStatus($status);
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('status_processing');
        }

        $checks = $this->checksRepository->findBy(['status' => Checks::STATUS_PROCESSING]);
        $totalOrders = count($checks);

        return $this->render('admin/status_processing.html.twig', [
            'checks' => $checks,
            'totalOrders' => $totalOrders,
        ]);
    }
    /**
     * @Route("/admin/order-paid", name="status_paid")
     */
    public function statusPaid(Request $request)
    {
        $checks = $this->checksRepository->findBy(['status' => Checks::STATUS_SHIPPED]);
        $totalOrders = count($checks);
        return $this->render('admin/status_paid.html.twig', [
            'checks' => $checks,
            'totalOrders' => $totalOrders,
        ]);
    }

    /**
     * @Route("/admin/order-canceled", name="status_canceled")
     */
    public function statusCanceled(Request $request)
    {
        $checks = $this->checksRepository->findBy(['status' => Checks::STATUS_CANCELLED]);
        $totalOrders = count($checks);
        return $this->render('admin/status_canceled.html.twig', [
            'checks' => $checks,
            'totalOrders' => $totalOrders,
        ]);
    }
    /**
     * @Route("/admin/order-expectation", name="status_expectation")
     */
    public function statusExpectation(Request $request)
    {
        $status = $request->query->get('status');
        $orderNumber = $request->query->get('orderNumber');

        if ($status && $orderNumber) {
            $orderNumbers = $this->checksRepository->findBy(['order_number' => $orderNumber]);

            foreach ($orderNumbers as $check) {
                $check->setStatus($status);
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('status_expectation');
        }

        $checks = $this->checksRepository->findBy(['status' => Checks::STATUS_CONFIRMED]);
        $totalOrders = count($checks);

        return $this->render('admin/status_expectation.html.twig', [
            'checks' => $checks,
            'totalOrders' => $totalOrders,
        ]);
    }

    /**
     * @Route("/admin/katalog", name="katalog")
     */
    public function katalog(Request $request)
    {
        $types = $this->entityManager->getRepository(Type::class)->findAll();

        return $this->render('admin/katalog.html.twig', [
            'types' => $types,
        ]);
    }

    /**
     * @Route("/admin/edit_type", name="edit_type", methods={"POST"})
     */
    public function editType(Request $request)
    {
        $katalogDirectory = $this->getParameter('katalog_directory');
        $id = $request->request->get('id');
        $name = $request->request->get('name');
        $imgFile = $request->files->get('img');

        $type = $this->entityManager->getRepository(Type::class)->find($id);

        if ($type) {
            $type->setName($name);
            if ($imgFile) {
                $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $imgFile->getClientOriginalExtension();
                $imgFile->move($katalogDirectory, $newFilename);
                $type->setImg($newFilename);
            }
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('katalog');
    }
    /**
     * @Route("/admin/katalog/add", name="add_type", methods={"POST"})
     */
    public function addType(Request $request)
    {
        $katalogDirectory = $this->getParameter('katalog_directory');
        $name = $request->request->get('name');
        $imgFile = $request->files->get('img');

        if ($imgFile) {
            $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename . '.' . $imgFile->getClientOriginalExtension();
            $imgFile->move($katalogDirectory, $newFilename);

            $type = new Type();
            $type->setName($name);
            $type->setImg($newFilename);

            $this->entityManager->persist($type);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('katalog');
    }
    /**
     * @Route("/admin/katalog/delete", name="delete_type", methods={"POST"})
     */
    public function deleteType(Request $request): JsonResponse
    {
        $id = json_decode($request->getContent(), true)['id'];
        $type = $this->entityManager->getRepository(Type::class)->find($id);

        if ($type) {
            $type->setDeleted(true);
            $this->entityManager->flush();
            return new JsonResponse(['status' => 'success']);
        }

        return new JsonResponse(['status' => 'error'], 404);
    }

    /**
     * @Route("/admin/katalog/restore", name="restore_type", methods={"POST"})
     */
    public function restoreType(Request $request): JsonResponse
    {
        $id = json_decode($request->getContent(), true)['id'];
        $type = $this->entityManager->getRepository(Type::class)->find($id);

        if ($type) {
            $type->setDeleted(false);
            $this->entityManager->flush();
            return new JsonResponse(['status' => 'success']);
        }

        return new JsonResponse(['status' => 'error'], 404);
    }

    /**
     * @Route("/admin/katalog/products/{name}/{typeId}", name="products")
     */
    public function products($name, $typeId)
    {
        $products = $this->entityManager->getRepository(Product::class)->findBy(['types' => $typeId]);

        return $this->render('admin/products.html.twig', [
            'products' => $products,
            'typeId' => $typeId, // Передаем typeId в шаблон

        ]);
    }


    /**
     * @Route("/admin/katalog/products/edit_product", name="edit_product", methods={"POST"})
     */
    public function editProduct(Request $request)
    {
        $katalogDirectory = $this->getParameter('katalog_directory');
        $id = $request->request->get('id');
        $name = $request->request->get('name');
        $amount = $request->request->get('amount');
        $noSale = $request->request->get('noSale');
        $discont = $request->request->get('discont');
        $imgFile = $request->files->get('img');

        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if ($product) {
            $product->setName($name);
            $product->setAmount($amount);
            $product->setNoSale($noSale);
            $product->setDiscont($discont);

            if ($imgFile) {
                $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $imgFile->getClientOriginalExtension();

                $imgFile->move($katalogDirectory, $newFilename);
                $product->setImg($newFilename);
            }

            $this->entityManager->flush();
            return $this->redirectToRoute('products', [
                'name' => $product->getName(),
                'typeId' => $product->getTypes()
            ]);
        }

        return new JsonResponse(['status' => 'error'], 404);
    }
    /**
     * @Route("/admin/katalog/products/delete_product", name="delete_product", methods={"POST"})
     */
    public function deleteProduct(Request $request): JsonResponse
    {
        $id = json_decode($request->getContent(), true)['id'];
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if ($product) {
            $product->setDeleted(1);
            $this->entityManager->flush();
            return new JsonResponse(['status' => 'success']);
        }

        return new JsonResponse(['status' => 'error'], 404);
    }

    /**
     * @Route("/admin/katalog/products/restore_product", name="restore_product", methods={"POST"})
     */
    public function restoreProduct(Request $request): JsonResponse
    {
        $id = json_decode($request->getContent(), true)['id'];
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if ($product) {
            $product->setDeleted(0);
            $this->entityManager->flush();
            return new JsonResponse(['status' => 'success']);
        }

        return new JsonResponse(['status' => 'error'], 404);
    }
    /**
     * @Route("/add_product/{typeId}", name="add_product", methods={"POST"})
     */
    public function addProduct(Request $request, $typeId)
    {
        $katalogDirectory = $this->getParameter('katalog_directory');
        $name = $request->request->get('name');
        $amount = $request->request->get('amount');
        $imgFile = $request->files->get('img');

        $product = new Product();
        $product->setName($name);
        $product->setAmount($amount);
        $product->setTypes($typeId);
        $product->setDeleted(0);

        if ($imgFile) {
            $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename . '.' . $imgFile->getClientOriginalExtension();

            $imgFile->move($katalogDirectory, $newFilename);
            $product->setImg($newFilename);
        }

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $this->redirectToRoute('products', [
            'name' => $name,
            'typeId' => $typeId,
        ]);
    }

    /**
     * @Route("/{typeId}/admin_info_product/{id}", name="admin_info_product")
     */
    public function mainpage($typeId, $id, Request $request, EntityManagerInterface $entityManager)
    {
        $product = $entityManager->getRepository(Product::class)->findOneBy(['types' => $typeId, 'id' => $id]);
        $images = $entityManager->getRepository(Images::class)->findBy(['id_product' => $id]);
        $infoProduct = $entityManager->getRepository(InfoProduct::class)->findOneBy(['id_product' => $id]);

        if (!$infoProduct) {
            $infoProduct = new InfoProduct();
            $infoProduct->setIdProduct($id);
            $infoProduct->setType($typeId);
            $infoProduct->setSale(0);
            $infoProduct->setTime(0);
        }

        if ($request->isMethod('POST')) {
            $infoProduct->setName($request->request->get('name'));
            $infoProduct->setPrice($request->request->get('price'));
            $infoProduct->setStock($request->request->get('stock'));
            $infoProduct->setDescription($request->request->get('description'));
            $infoProduct->setManufacturer($request->request->get('manufacturer'));
            $infoProduct->setWeight($request->request->get('weight'));
            $infoProduct->setVolume($request->request->get('volume'));
            $infoProduct->setVoltage($request->request->get('voltage'));
            $infoProduct->setRown($request->request->get('rown'));
            $infoProduct->setEngine($request->request->get('engine'));
            $infoProduct->setPower($request->request->get('power'));
            $infoProduct->setMixtures($request->request->get('mixtures'));
            $infoProduct->setDrive($request->request->get('drive'));
            $infoProduct->setRetainer($request->request->get('retainer'));
            $infoProduct->setConnections($request->request->get('connections'));
            $infoProduct->setWheels($request->request->get('wheels'));
            $infoProduct->setDimensions($request->request->get('dimensions'));
            $infoProduct->setCountry($request->request->get('country'));
            $infoProduct->setMotherland($request->request->get('motherland'));

            $uploadDir = $this->getParameter('katalog_directorys');

            $replaceImages = $request->files->get('replaceImages');
            if ($replaceImages && count($replaceImages) > 0) {
                foreach ($replaceImages as $imageId => $imgFile) {
                    if ($imgFile) {
                        $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                        $newFilename = $originalFilename . '-' . uniqid() . '.' . $imgFile->getClientOriginalExtension();
                        $imgFile->move($uploadDir, $newFilename);

                        $img = $entityManager->getRepository(Images::class)->find($imageId);
                        if ($img) {
                            $img->setImg($newFilename);
                            $entityManager->persist($img);

                            if ($infoProduct->getImg() == $img->getImg()) {
                                $infoProduct->setImg($newFilename);
                            }
                        }
                    }
                }
            }

            $imgFiles = $request->files->get('images');
            if ($imgFiles && count($imgFiles) > 0) {
                $uploadedCount = 0;
                foreach ($imgFiles as $imgFile) {
                    if ($imgFile && $uploadedCount < 4) {
                        $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                        $newFilename = $originalFilename . '-' . uniqid() . '.' . $imgFile->getClientOriginalExtension();
                        $imgFile->move($uploadDir, $newFilename);

                        $img = new Images();
                        $img->setIdProduct($id);
                        $img->setImg($newFilename);

                        $entityManager->persist($img);

                        if ($uploadedCount == 0 && !$infoProduct->getImg()) {
                            $infoProduct->setImg($newFilename);
                        }

                        $uploadedCount++;
                    }
                }
            }

            $entityManager->persist($infoProduct);
            $entityManager->flush();

            $this->addFlash('success', 'Информация о товаре обновлена');
            return $this->redirectToRoute('admin_info_product', ['typeId' => $typeId, 'id' => $id]);
        }

        $products = $entityManager->getRepository(Product::class)->findBy(['types' => $typeId]);
        $similarProducts = [];
        foreach ($products as $similarProduct) {
            if ($similarProduct->getId() != $id) {
                $similarProducts[] = $similarProduct;
            }
        }

        return $this->render('admin/AdminInfoProduct.html.twig', [
            'product' => $product,
            'images' => $images,
            'infoProduct' => $infoProduct,
            'products' => $similarProducts
        ]);
    }

    /**
     * @Route("/admin/brend", name="brend")
     */
    public function list(Request $request)
    {
        $imgs =  $this->entityManager->getRepository(PopularBrend::class)->findAll();

        return $this->render('admin/brand.html.twig', [
            'imgs' => $imgs,
        ]);
    }
    /**
     * @Route("/admin/brand/add", name="add_popular_brand", methods={"POST"})
     */
    public function add(Request $request, SluggerInterface $slugger): Response
    {
        $uploadedFile = $request->files->get('brandImage');
        if ($uploadedFile) {
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->getClientOriginalExtension();

            try {
                $uploadedFile->move(
                    $this->getParameter('brand_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
            }

            $popularBrend = new PopularBrend();
            $popularBrend->setImg($newFilename);

            $this->entityManager->persist($popularBrend);
            $this->entityManager->flush();

            return $this->redirectToRoute('brend');
        }

        return new Response('Ошибка загрузки файла', Response::HTTP_BAD_REQUEST);
    }
    /**
     * @Route("/admin/brand/delete/{id}", name="delete_brand", methods={"POST"})
     */
    public function deleteBrand($id): JsonResponse
    {
        $brand = $this->entityManager->getRepository(PopularBrend::class)->find($id);

        if ($brand) {
            $brand->setDeleted(1);
            $this->entityManager->flush();
            return new JsonResponse(['status' => 'success']);
        }

        return new JsonResponse(['status' => 'error', 'message' => 'Brand not found']);
    }

    /**
     * @Route("/admin/brand/restore/{id}", name="restore_brand", methods={"POST"})
     */
    public function restoreBrand($id): JsonResponse
    {
        $brand = $this->entityManager->getRepository(PopularBrend::class)->find($id);

        if ($brand) {
            $brand->setDeleted(0);
            $this->entityManager->flush();
            return new JsonResponse(['status' => 'success']);
        }

        return new JsonResponse(['status' => 'error', 'message' => 'Brand not found']);
    }
}