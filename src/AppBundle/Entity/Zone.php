<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Zone
 *
 * @ORM\Table(name="zone")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ZoneRepository")
 */
class Zone
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="capacity", type="integer", nullable=true)
     */
    private $capacity;

    /**
     * @var Session[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Session",
     *     mappedBy="zone", cascade={"persist"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $sessions;

    /**
     * @var Coordinate[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Coordinate",
     *     mappedBy="zone", cascade={"persist"})
     */
    private $coordinates;

    /**
     * @var string
     *
     * @ORM\Column(name="area", type="text", nullable=true)
     */
    private $area;


    public function __toString()
    {
        return $this->title . "";
    }

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
        $this->coordinates = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Zone
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set capacity
     *
     * @param integer $capacity
     * @return Zone
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get capacity
     *
     * @return integer 
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set sessions
     *
     * @param Session $sessions
     * @return Zone
     */
    public function setSessions($sessions)
    {
        $this->sessions = $sessions;

        return $this;
    }

    /**
     * Get sessions
     *
     * @return Session[]
     */
    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     * Add session
     * @param Session $session
     * @return Zone
     */
    public function addSession(Session $session)
    {
        $this->sessions->add($session);
        return $this;
    }

    /**
     * @return Coordinate[]
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @param Coordinate[] $coordinates
     */
    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;
    }

    /**
     * @return string
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param string $area
     */
    public function setArea($area)
    {
        $this->area = $area;
    }

}
