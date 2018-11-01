<?php

namespace AppBundle\Encoder;

use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class PasswordEncoder
{

    private $encoderFactory;

    /**
     * @param $encoderFactory EncoderFactory
     */
    public function __construct($encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param $user User
     * @param $password
     * @return string
     */
    public function encode($user, $password)
    {
        $encoder = $this->encoderFactory->getEncoder($user);
        return $encoder->encodePassword($password, $user->getSalt());
    }
}