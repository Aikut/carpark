<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CarAdmin extends AbstractAdmin
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
            ->add('title', null, array('label' =>  'Номер'))
            ->add('session', null, array('label' => 'Сессия'))
            ->add('breaker', null, array('label' => 'Нарушитель'))
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
            ->add('title', null, array('label' =>  'Номер'))
            ->add('session', null, array('label' => 'Сессия'))
            ->add('user', null, array('label' => 'Пользователь'))
            ->add('breaker', null, array('label' => 'Нарушитель'))
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
            ->add('title', null, array('label' =>  'Номер'))
            ->add('session', null, array('label' => 'Сессия'))
            ->add('breaker', null, array('label' => 'Нарушитель'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id', null, array('label' => 'ID'))
            ->add('created', null, array('label' => 'Дата добавление'))
            ->add('title', null, array('label' =>  'Номер'))
            ->add('session', null, array('label' => 'Сессия'))
            ->add('breaker', null, array('label' => 'Нарушитель'))
        ;
    }
}
