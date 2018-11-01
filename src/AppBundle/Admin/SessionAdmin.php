<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SessionAdmin extends AbstractAdmin
{
    public function configure()
    {
        parent::configure();
        $this->datagridValues['_sort_by']    = 'id';
        $this->datagridValues['_sort_order'] = 'DESC';
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array('label' => 'ID'))
            ->add('title', null, array('label' =>  'Название'))
            ->add('zone', null, array('label' => 'Зона'))
            ->add('user', null, array('label' => 'Пользователь'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, array('label' => 'ID'))
            ->add('title', null, array('label' =>  'Название'))
            ->add('zone', null, array('label' => 'Зона'))
            ->add('user', null, array('label' => 'Пользователь'))
            ->add('cars', 'string', array(
                'label' => 'Кол-во авто',
                'template' => 'AppBundle:Admin:array_size.html.twig'
            ))
            ->add('_action', null, array(
                'label' => 'управление',
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', null, array('label' =>  'Название'))
            ->add('zone', null, array('label' => 'Зона'))
            ->add('user', null, array('label' => 'Пользователь'))
            ->add('created', null, array('label' =>  'Дата добавления'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title', null, array('label' =>  'Название'))
            ->add('zone', null, array('label' => 'Зона'))
            ->add('user', null, array('label' => 'Пользователь'))
            ->add('created', null, array('label' =>  'Дата добавления'))
            ->add('cars', null, array('label' =>  'Авто'))
        ;
    }
}
