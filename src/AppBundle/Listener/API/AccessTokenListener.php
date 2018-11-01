<?php

namespace AppBundle\Listener\API;

use Doctrine\ORM\EntityManager;
use AppBundle\Exception\API\ApiException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AccessTokenListener
{
    private $entityManager;
    private $tokenStorage;
    private $exclude = [
        '/api/login', '/api/zone/list',
    ];

    const EMPTY_ACCESS_TOKEN = 'Empty access token';
    const INVALID_ACCESS_TOKEN = 'Invalid access token';
    const ACCESS_TOKEN_EXPIRED = 'Access token has expired';

    public function __construct(EntityManager $entityManager, TokenStorage $tokenStorage)
    {

        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    private function getByAccessToken($accessToken)
    {
        return $this->entityManager->getRepository('AppBundle:UserAccessToken')->findOneBy(array('accessToken' => $accessToken));
    }

    public function beforeController(GetResponseEvent $event)
    {
        $url = $event->getRequest()->getPathInfo();

        $accessToken = $event->getRequest()->headers->get('token');

        if ((strpos($url, '/api/v1') !== 0 || in_array($url, $this->exclude)) && $accessToken == null ) return;


        if (!$accessToken) {
            throw new ApiException(self::EMPTY_ACCESS_TOKEN, Response::HTTP_FORBIDDEN);
        }

        $token = $this->getByAccessToken($accessToken);

        if (!$token) {
            throw new ApiException(self::INVALID_ACCESS_TOKEN, Response::HTTP_FORBIDDEN);
        }

        if ($token->getExpiredAt() <= new \DateTime('now')) {
            throw new ApiException(self::ACCESS_TOKEN_EXPIRED, Response::HTTP_FORBIDDEN);
        }

        $user = $token->getUser();

        $usernamePasswordToken = new UsernamePasswordToken($user, $user->getPassword(), "fos_userbundle", $user->getRoles());
        $this->tokenStorage->setToken($usernamePasswordToken);
    }
}