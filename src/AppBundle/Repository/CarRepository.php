<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Zone;
use Doctrine\ORM\EntityRepository;

/**
 * CarRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CarRepository extends EntityRepository
{
    public function findByZone(Zone $zone)
    {
        $entities = $this->createQueryBuilder('c')
            ->join('c.session', 's')
            ->where('s.zone = :zone')
            ->setParameter('zone', $zone)
            ->orderBy('c.created', 'DESC')
            ->getQuery()->getResult();
        return $entities;
    }
}
