<?php

namespace AiO\CoreBundle\Services;


use Doctrine\ORM\EntityManager;
use Sonata\MediaBundle\Twig\Extension\MediaExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Parser;

class BaseService
{
    public function quotesToHTML($data)
    {
        $data = strip_tags($data);
        $data = htmlentities($data, ENT_QUOTES, "UTF-8");
        $data = htmlspecialchars($data, ENT_QUOTES);
        return $data;
    }

    public function getRequestAttribute($request)
    {
        $array=[];
        foreach ($request as $key=>$value){
            $array[$key] = $this->quotesToHTML($value);
        }
        return $array;
    }
}
