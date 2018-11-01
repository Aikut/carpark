<?php

/**
 * Created by PhpStorm.
 * User: adilet
 * Date: 1/20/18
 * Time: 8:15 PM
 */
namespace AiO\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Session\Session;


class BaseEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    public function __toString()
    {
        $session = new Session();
        if($session->get("locale")=='ru')
            return $this->getTitleRu();
        elseif($session->get("locale")=='ky')
            return $this->getTitleKy();
        else
            return $this->getTitleEn();
    }



}