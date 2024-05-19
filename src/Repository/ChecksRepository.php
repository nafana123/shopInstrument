<?php

namespace App\Repository;

use App\Entity\Checks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Checks>
 *
 * @method Checks|null find($id, $lockMode = null, $lockVersion = null)
 * @method Checks|null findOneBy(array $criteria, array $orderBy = null)
 * @method Checks[]    findAll()
 * @method Checks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChecksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Checks::class);
    }


//    /**
//     * @return Checks[] Returns an array of Checks objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Checks
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
