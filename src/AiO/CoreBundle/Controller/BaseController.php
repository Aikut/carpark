<?php

namespace AiO\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
    protected $namespace           = 'AiOCoreBundle:';
    protected $commonNamespace     = 'AiOCoreBundle:';
    protected $commonNamespacePath = 'AiO\CoreBundle';
    protected $tplEngine           = '.html.twig';
    protected $translationWhere    = 'tr.locale = :locale AND tr.title IS NOT NULL';
    protected $where               = '1 = 1';
    protected $andWhere            = ' AND 1 = 1';
    protected $orderBy             = array('a.id', 'DESC');
    protected $data                = array();


    protected $errors = array(
        404 => 'Item not found!',
        405 => 'Action not allowed',
        900 => 'An error occured!',
    );

    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function setTplEngine($tplEngine)
    {
        $this->tplEngine = $tplEngine;
    }

    public function getTplEngine()
    {
        return $this->tplEngine;
    }

    public function getData()
    {
        return $this->data;
    }
    public function renderData(array $data = array())
    {
        $this->data += $data;
        return $this;
    }
    public function renderTpl($action, $params = array(), $common = false)
    {
        if ($common === false) {
            $nsp = $this->getNamespace();
        } else {
            $nsp = $this->commonNamespace;
        }

        $this->renderData($params);

        return $this->render($nsp . $action . $this->getTplEngine(), $this->getData());
    }
    public function getEm()
    {
        return $this->get('doctrine')->getEntityManager();
    }

    public function getRepo($entity)
    {
        return $this->getEm()->getRepository($this->commonNamespace . $entity);
    }

    public function getLocale()
    {
        return $this->get('request')->getLocale();
    }

    public function getList($entity, $translations = true) //Entity name = string, Translatable = boolean
    {
        $locale = $this->getLocale();
        $repository = $this->getRepo($entity);

        if($translations){

            $entities = $repository->createQueryBuilder('a')
                ->join('a.translations', 'tr')
                ->where($this->translationWhere . $this->andWhere)
                ->orderBy($this->orderBy[0], $this->orderBy[1])
                ->setParameter('locale', $locale)
                ->getQuery()
                ->getResult();
        }else{
            $entities = $repository->createQueryBuilder('a')
                ->where($this->where)
                ->orderBy($this->orderBy[0], $this->orderBy[1])
                ->getQuery()
                ->getResult();
        }
        return $entities;
    }


    public function getLast($entity, $translations = true, $limit) //Entity name = string, Translatable = boolean, limit  = integer
    {
        $locale = $this->getLocale();
        $repository = $this->getRepo($entity);

        if($translations){
            $entities = $repository->createQueryBuilder('a')
                ->join('a.translations', 'tr')
                ->where($this->translationWhere)
                ->orderBy($this->orderBy[0], $this->orderBy[1])
                ->setParameter('locale', $locale)
                ->setFirstResult(0)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
        }else{
            $entities = $repository->createQueryBuilder('a')
                ->where($this->where)
                ->orderBy($this->orderBy[0], $this->orderBy[1])
                ->setFirstResult(0)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
        }
        return $entities;
    }

    public function getPagination($entities, $limit)
    {
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->getInt('page', 1)/* page number */,
            $limit
        );
        return $pagination;
    }

    public function getAll($entity)
    {
        return $this->getRepo($entity)->findAll();
    }

    public function findOne($entity, $entityId)
    {
        return $this->getEm()->find($this->commonNamespace . $entity, $entityId);
    }

    public function findOneOtherBundle($bundle, $entity, $entityId)
    {
        return $this->getEm()->find($bundle . $entity, $entityId);
    }


    public function notFound($message)
    {
        throw $this->createNotFoundException($this->errors[$message]);
    }

    public function accessDenied($message = null, $common = true)
    {
        //return $this->renderTpl('Error:error', ErrorController::error(405, $message), $common);
    }





}
