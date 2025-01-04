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
}
