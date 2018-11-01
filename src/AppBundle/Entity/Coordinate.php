<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coordinate
 *
 * @ORM\Table(name="coordinate")
 * @ORM\Entity()
 */
class Coordinate
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="lat", type="string", length=255)
     */
    private $lat;


    /**
     * @var string
     *
     * @ORM\Column(name="lng", type="string", length=255)
     */
    private $lng;


    /**
     * @var Zone
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Zone", inversedBy="coordinates", cascade={"persist"})
     * @ORM\JoinColumn(name="zone_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $zone;


    public function __toString()
    {
        return '[ ' . $this->lat . ', ' . $this->lng . ' ]';
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param string $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param string $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * @return Zone
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * @param Zone $zone
     */
    public function setZone($zone)
    {
        $this->zone = $zone;
    }

}
