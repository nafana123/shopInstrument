<?php

namespace App\Repository;

use App\Entity\Basket;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findAllSearchName($searchName, $typeId, $priceFrom, $priceTo, $sortPrice, $discounts)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.types = :typeId')
            ->setParameter('typeId', $typeId);

        if ($searchName !== null && $searchName !== '') {
            $qb->andWhere('p.name LIKE :searchName')
                ->setParameter('searchName', '%' . $searchName . '%');
        }

        if ($priceFrom !== null && $priceFrom !== '') {
            $qb->andWhere('p.amount >= :priceFrom')
                ->setParameter('priceFrom', $priceFrom);
        }

        if ($priceTo !== null && $priceTo !== '') {
            $qb->andWhere('p.amount <= :priceTo')
                ->setParameter('priceTo', $priceTo);
        }



        if ($sortPrice === 'asc') {
            $qb->orderBy('p.amount', 'ASC');
        } elseif ($sortPrice === 'desc') {
            $qb->orderBy('p.amount', 'DESC');
        }

        if (!empty($discounts)) {
            $qb->andWhere('p.discont IN (:discounts)')
                ->setParameter('discounts', $discounts);
        }

        return $qb->getQuery()->getResult();
    }

    public function productSearch($productSearch){
        $qb = $this->createQueryBuilder('p');
        if ($productSearch !== null && $productSearch !== '') {
            $qb->andWhere('p.name LIKE :productSearch')
                ->setParameter('productSearch', '%' . $productSearch . '%');
        }
        return $qb->getQuery()->getResult();

    }

    public function findProductById($id)
    {
        return $this->find($id);
    }

    public function findSimilarProducts($typeId, $productId)
    {
        return $this->createQueryBuilder('p')
            ->where('p.types = :typeId')
            ->andWhere('p.id != :productId')
            ->setParameter('typeId', $typeId)
            ->setParameter('productId', $productId)
            ->getQuery()
            ->getResult();
    }

    public function findPopularProducts()
    {
        return $this->findBy([], ['amount' => 'DESC'], 4);
    }

}
