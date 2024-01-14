<?php

namespace App\Repository\Sensor;

use App\Entity\Sensor\Measurement;
use App\Entity\Sensor\Sensor;
use App\Model\Enum\MeasurementType;
use App\Model\Enum\PeriodType;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\OrderBy;
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
        parent::__construct($registry, Measurement::class);
    }

    public function findByType(Sensor $sensor, MeasurementType $type, PeriodType $period)
    {
        $qb = $this->createQueryBuilder('m')
            ->select("m.{$type->value} as measure, m.createdAt")
            ->join('m.sensor', 's')
            ->andWhere('s.macAddress = :sensorMacAddress')
            ->setParameter('sensorMacAddress', $sensor->getMacAddress())
            ->andWhere('m.createdAt between :periodStart and :periodEnd')
            ->setParameter('periodEnd', (new DateTime())->format('Y-m-d H:i:s'))
        ;


        match ($period) {
            PeriodType::Hour => $qb->setParameter('periodStart', (new DateTime('-1 hour'))->format('Y-m-d H:i:s')),
            PeriodType::Day => $qb->setParameter('periodStart', (new DateTime('-1 day'))->format('Y-m-d H:i:s')),
            PeriodType::Week => $qb->setParameter('periodStart', (new DateTime('-1 week'))->format('Y-m-d H:i:s')),
            PeriodType::Month => $qb->setParameter('periodStart', (new DateTime('-1 month'))->format('Y-m-d H:i:s')),
            PeriodType::Quarter => $qb->setParameter('periodStart', (new DateTime('-3 month'))->format('Y-m-d H:i:s')),
            PeriodType::Year => $qb->setParameter('periodStart', (new DateTime('-1 year'))->format('Y-m-d H:i:s')),
        };

        return $qb
            ->addOrderBy(new OrderBy('m.createdAt', 'ASC'))
            ->getQuery()
            ->getResult()
            ;
    }
}