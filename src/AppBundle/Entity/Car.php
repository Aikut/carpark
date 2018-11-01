<?php

namespace AppBundle\Entity;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="car")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarRepository")
 */
class Car
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
     * @var bool
     *
     * @ORM\Column(name="breaker", type="boolean")
     */
    private $breaker;

    /**
     * @var Session
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Session", inversedBy="cars", cascade={"persist"})
     * @ORM\JoinColumn(name="session_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $session;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $user;

    public function __toString()
    {
        return $this->title;
    }

    public function __construct()
    {
        $this->breaker = false;
        $this->created = new \DateTime();
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
     * @return Car
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
     * Set breaker
     *
     * @param boolean $breaker
     * @return Car
     */
    public function setBreaker($breaker)
    {
        $this->breaker = $breaker;

        return $this;
    }

    /**
     * Get breaker
     *
     * @return boolean 
     */
    public function getBreaker()
    {
        return $this->breaker;
    }

    /**
     * Set session
     *
     * @param Session $session
     * @return Car
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
        $session->addCar($this);
        return $this;
    }

    /**
     * Get session
     *
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
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
}
