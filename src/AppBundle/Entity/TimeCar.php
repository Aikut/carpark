<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TimeCar
 *
 * @ORM\Table(name="time_car")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TimeCarRepository")
 */
class TimeCar
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
     * @var int
     *
     * @ORM\Column(name="carNum", type="integer")
     */
    private $carNum;

    /**
     * @var int
     *
     * @ORM\Column(name="zone", type="integer")
     */
    private $zone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="time", nullable=true)
     */
    private $time;


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
     * Set carNum
     *
     * @param integer $carNum
     * @return TimeCar
     */
    public function setCarNum($carNum)
    {
        $this->carNum = $carNum;

        return $this;
    }

    /**
     * Get carNum
     *
     * @return integer 
     */
    public function getCarNum()
    {
        return $this->carNum;
    }

    /**
     * Set zone
     *
     * @param integer $zone
     * @return TimeCar
     */
    public function setZone($zone)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return integer 
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     * @return TimeCar
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        return $this->time;
    }
}
