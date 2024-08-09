<?php

namespace App\Repository;

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

    public function findAllSearchName($searchName, $typeId, $priceFrom, $priceTo)
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

        return $qb->getQuery()->getResult();
    }



}
