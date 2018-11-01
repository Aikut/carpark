<?php

namespace AiO\CoreBundle\Listener;


use Symfony\Component\HttpFoundation\Session\Session;

class EventListener
{
    public function beforeController()
    {
        $session = new Session();
        if(!$session->get("locale"))
            $session->set("locale", "ru");
    }
}