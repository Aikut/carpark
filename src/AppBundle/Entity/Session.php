<?php

namespace AppBundle\Entity;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Session
 *
 * @ORM\Table(name="session")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SessionRepository")
 */
class Session
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
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closed_at", type="datetime", nullable=true)
     */
    private $closedAt;


    /**
     * @var boolean
     *
     * @ORM\Column(name="closed", type="boolean", nullable=true)
     */
    private $closed;



    /**
     * @var Zone
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Zone", inversedBy="sessions", cascade={"persist"})
     * @ORM\JoinColumn(name="zone_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $zone;

    /**
     * @var Car[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Car",
     *     mappedBy="session", cascade={"persist"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $cars;


    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $user;


    public function __toString()
    {
        return $this->zone . " Сессия "  . $this->title . "";
    }

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->cars = new ArrayCollection();

        $result = $this->created->format('d-m-Y H:i');
        $this->title = $result;

        $this->closed = false;
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
     * @return Session
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
     * Set created
     *
     * @param \DateTime $created
     * @return Session
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set zone
     *
     * @param Zone $zone
     * @return Session
     */
    public function setZone(Zone $zone)
    {
        $this->zone = $zone;
        $zone->addSession($this);
        return $this;
    }

    /**
     * Get zone
     *
     * @return Zone
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Set cars
     *
     * @param Car $cars
     * @return Session
     */
    public function setCars($cars)
    {
        $this->cars = $cars;

        return $this;
    }

    /**
     * Get cars
     *
     * @return Car[]
     */
    public function getCars()
    {
        return $this->cars;
    }

    /**
     * Add car
     * @param Car $car
     * @return Session
     */
    public function addCar(Car $car)
    {
        $this->cars->add($car);
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return bool
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * @param bool $closed
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
    }

    /**
     * @return \DateTime
     */
    public function getClosedAt()
    {
        return $this->closedAt;
    }

    /**
     * @param \DateTime $closedAt
     */
    public function setClosedAt($closedAt)
    {
        $this->closedAt = $closedAt;
    }

}
