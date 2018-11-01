<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CoordinateAdmin extends AbstractAdmin
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
            ->add('zone', null, array('label' => 'Зона'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, array('label' => 'ID'))
            ->add('zone', null, array('label' => 'Зона'))
            ->add('lat', null, array('label' => 'Широта'))
            ->add('lng', null, array('label' => 'Долгота'))

            ->add('_action', null, array(
                'label' => 'управление',
                'actions' => array(
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
            ->add('zone', null, array('label' => 'Зона'))
            ->add('lat', null, array('label' => 'Широта'))
            ->add('lng', null, array('label' => 'Долгота'))
        ;
    }
}
