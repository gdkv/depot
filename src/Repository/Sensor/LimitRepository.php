<?php

namespace App\Repository\Sensor;

use App\Entity\Sensor\Limit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Info>
 *
 * @method Limit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Limit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Limit[]    findAll()
 * @method Limit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LimitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Limit::class);
    }


}