<?php

namespace App\Repository\Sensor;

use App\Entity\Sensor\Measurement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Info>
 *
 * @method Measurement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Measurement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Measurement[]    findAll()
 * @method Measurement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeasurementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Info::class);
    }

}