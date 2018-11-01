<?php

namespace AppBundle\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class ApiController extends Controller
{
    protected function prepareJsonResponse($object)
    {
        return new Response(
            $this->get('jms_serializer')->serialize($object, 'json'), 200, array(
            'Content-Type' => 'application/json',
        )
        );
    }
}