<?php

namespace App\Repository;

use App\Entity\PopularBrend;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PopularBrend>
 *
 * @method PopularBrend|null find($id, $lockMode = null, $lockVersion = null)
 * @method PopularBrend|null findOneBy(array $criteria, array $orderBy = null)
 * @method PopularBrend[]    findAll()
 * @method PopularBrend[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PopularBrendRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PopularBrend::class);
    }

//    /**
//     * @return PopularBrend[] Returns an array of PopularBrend objects
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

//    public function findOneBySomeField($value): ?PopularBrend
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
