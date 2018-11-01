<?php

namespace AppBundle\Service;

use AppBundle\Formatter\ZoneFormatter;
use Doctrine\ORM\EntityManager;

class MapService
{
    private $em;
    private $formatter;

    public function __construct(EntityManager $em, ZoneFormatter $formatter)
    {
        $this->em = $em;
        $this->formatter = $formatter;
    }

    public function zoneList()
    {
        $entities = $this->em->getRepository('AppBundle:Zone')->findAll();
        $entities = $this->formatter->formatAll($entities);
        return $entities;
    }
}