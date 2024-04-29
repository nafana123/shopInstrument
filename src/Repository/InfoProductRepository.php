<?php

namespace App\Repository;

use App\Entity\InfoProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InfoProduct>
 *
 * @method InfoProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoProduct[]    findAll()
 * @method InfoProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfoProduct::class);
    }

//    /**
//     * @return InfoProduct[] Returns an array of InfoProduct objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InfoProduct
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
