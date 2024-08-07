<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\InfoProduct;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class basketController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @Route("/basket", name="basket", methods={"GET", "POST"})
     */
    public function list(Request $request)
    {
        $user = $this->getUser();
        $id = $request->query->get('id');

        if ($request->isMethod('POST')) {
            $infoProduct = $this->em->getRepository(Product::class);
            $product = $infoProduct->findOneBy(['id' => $id]);

            if ($product) {
                $existingBasketItem = $this->em->getRepository(Basket::class)
                    ->findOneBy(['user' => $user, 'name' => $product->getName()]);

                if (!$existingBasketItem) {
                    $basket = new Basket();
                    $basket->setName($product->getName());
                    $basket->setPrice($product->getAmount());
                    $basket->setQuantity(1);
                    $basket->setUser($user);
                    $basket->setImg($product->getImg());
                    $basket->setProduct($product);

                    $this->em->persist($basket);
                    $this->em->flush();
                }
            }

            return $this->redirectToRoute('basket');
        }

        $basketItems = $this->em->getRepository(Basket::class)->findBy(['user' => $user]);


        return $this->render('basket.html.twig', [
            'cartItems' => $basketItems,
        ]);
    }

    /**
     * @Route("/basket/delete/{id}", name="basket_delete", methods={"DELETE"})
     */
    public function deleteItem($id)
    {
        $user = $this->getUser();
        $basketItem = $this->em->getRepository(Basket::class)
            ->findOneBy(['user' => $user, 'id' => $id]);

        if ($basketItem) {
            $this->em->remove($basketItem);
            $this->em->flush();
            return $this->json(['status' => 'success']);
        }

        return $this->json(['status' => 'error', 'message' => 'Item not found'], 404);
    }

    /**
     * @Route("/basket/quantity", name="basket_quantity", methods={"GET"})
     */
    public function basketQuantity()
    {
        $user = $this->getUser();
        $basketItems = $this->em->getRepository(Basket::class)->findBy(['user' => $user]);

        $isEmpty = empty($basketItems);

        return $this->json([
            'status' => $isEmpty ? 'success' : 'error'
        ]);
    }

    /**
     * @Route("/basket/increment/{id}", name="basket_increment", methods={"POST"})
     */
    public function incrementQuantity($id)
    {
        $user = $this->getUser();
        $basketItem = $this->em->getRepository(Basket::class)
            ->findOneBy(['user' => $user, 'id' => $id]);

        if ($basketItem) {
            $basketItem->setQuantity($basketItem->getQuantity() + 1);
            $this->em->flush();
            return $this->json(['status' => 'success', 'quantity' => $basketItem->getQuantity()]);
        }

        return $this->json(['status' => 'error', 'message' => 'Item not found'], 404);
    }

    /**
     * @Route("/basket/decrement/{id}", name="basket_decrement", methods={"POST"})
     */
    public function decrementQuantity($id)
    {
        $user = $this->getUser();
        $basketItem = $this->em->getRepository(Basket::class)
            ->findOneBy(['user' => $user, 'id' => $id]);

        if ($basketItem) {
            if ($basketItem->getQuantity() > 1) {
                $basketItem->setQuantity($basketItem->getQuantity() - 1);
                $this->em->flush();
                return $this->json(['status' => 'success', 'quantity' => $basketItem->getQuantity()]);
            } else {
                return $this->json(['status' => 'error', 'message' => 'Quantity cannot be less than 1'], 400);
            }
        }

        return $this->json(['status' => 'error', 'message' => 'Item not found'], 404);
    }


}