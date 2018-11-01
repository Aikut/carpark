<?php

namespace AppBundle\Formatter;


use AppBundle\Entity\Zone;

class ZoneFormatter
{


    /**
     * @param Zone|Zone[] $entities
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
        /* @var $entity Zone */

        $area = $this->getArea($entity->getArea());

        return array(
            'id'            => $entity->getId(),
            'title'         => $entity->getTitle(),
            'capacity'      => $entity->getCapacity(),
            'area'          => $area,
            'center'        => $this->zoneCenter($area)
        );
    }


    private function zoneCenter($area)
    {
        $minLat = 1000; $maxLat = -1;
        $minLng = 1000; $maxLng = -1;

        foreach ($area as $latLng){
            $minLat = min($latLng["lat"], $minLat);
            $maxLat = max($latLng["lat"], $maxLat);

            $minLng = min($latLng["lng"], $minLng);
            $maxLng = max($latLng["lng"], $maxLng);
        }

        $lat = $minLat + (($maxLat - $minLat) / 2);
        $lng = $minLng + (($maxLng - $minLng) / 2);//(mapLabelLngMax + mapLabelLngMin) / 2;

        return array(
            'lat' => $lat,
            'lng' => $lng
        );
    }

    private function getArea($text)
    {
        $text = preg_replace("/[^0-9,. ]/", "", $text);

        $latlngs = explode(',', $text);

        $coordinates = array();

        foreach ($latlngs as $ll){
            $a = explode(' ', $ll);

            if (sizeof($a) == 2){
                $coordinates[] = array(
                    'lat' => floatval($a[1]),
                    'lng' => floatval($a[0])
                );
            }
        }

        return $coordinates;
    }
}