<?php

namespace App\Repository;

use App\Entity\ProductCharacteristics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductCharacteristics>
 *
 * @method ProductCharacteristics|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductCharacteristics|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductCharacteristics[]    findAll()
 * @method ProductCharacteristics[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductCharacteristicsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductCharacteristics::class);
    }

//    /**
//     * @return ProductCharacteristics[] Returns an array of ProductCharacteristics objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProductCharacteristics
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
