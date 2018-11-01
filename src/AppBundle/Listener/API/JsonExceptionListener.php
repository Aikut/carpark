<?php

namespace AppBundle\Listener\API;

use AppBundle\Exception\API\ApiException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;


class JsonExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($event->getException() instanceof ApiException) {
            $exception = $event->getException();
            $data = array(
                'error' => array(
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage()
                )
            );
            $response = new JsonResponse($data);
            $event->setResponse($response);
            $event->stopPropagation();
        }
    }
}