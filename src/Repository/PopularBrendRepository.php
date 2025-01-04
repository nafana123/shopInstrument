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
}
