<?php

namespace AppBundle\Formatter;


use AppBundle\Entity\Session;

class SessionFormatter
{
    /**
     * @param Session|Session[] $entities
     *
     * @return array
     */
    public function formatAll($entities)
    {
        $formattedArray = array();

        foreach ($entities as $entity) {
            $formattedArray[] = $this->format($entity);
        }

        return $formattedArray;
    }

    public function format($entity)
    {
        /* @var $entity Session */
        if ($entity->getZone()->getCapacity()){
            $percent = (100 * sizeof($entity->getCars())) / ($entity->getZone()->getCapacity());
        } else{
            $percent = 0;
        }
        return array(
            'id'            => $entity->getId(),
            'title'         => $entity->getTitle(),
            'zone'          => $entity->getZone()->getTitle(),
            'zoneCapacity'  => $entity->getZone()->getCapacity(),
            'countCar'      => sizeof($entity->getCars()),
            'percent'       => $percent,
            'closed'        => $entity->getClosed(),
            'user'          => $entity->getUser()
        );
    }

}