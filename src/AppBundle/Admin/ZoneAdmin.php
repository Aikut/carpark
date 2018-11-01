<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ZoneAdmin extends AbstractAdmin
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
            ->add('title', null, array('label' => 'Название'))
            ->add('capacity', null, array('label' => 'Емкость'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, array('label' => 'ID'))
            ->add('title', null, array('label' => 'Название'))
            ->add('capacity', null, array('label' => 'Емкость'))
            ->add('sessions', 'string', array(
                'label' => 'Кол-во сессий',
                'template' => 'AppBundle:Admin:array_size.html.twig'
            ))
            ->add('_action', null, array(
                'label' => 'Управление',
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
//            ->with(' ', array('class' => 'col-md-12'))
            ->add('title', null, array('label' => 'Название', 'attr'=>array('class'=>'col-md-6')))
            ->add('capacity', null, array('label' => 'Емкость', 'attr'=>array('class'=>'col-md-6')))
//            ->end()
            ->add('area', null, array(
                'label' => 'Координаты',
                'required' => true,
                'attr' =>  array('class' => 'zone-area')
            ))

        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id', null, array('label' => 'ID'))
            ->add('title', null, array('label' => 'Название'))
            ->add('capacity', null, array('label' => 'Емкость'))
            ->add('coordinates', null, array('label' => 'Координаты'))
            ->add('sessions', null, array('label' => 'Сессии'))
        ;
    }
}
