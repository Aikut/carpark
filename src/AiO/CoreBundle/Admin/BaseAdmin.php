<?php

namespace AiO\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class BaseAdmin extends AbstractAdmin
{

    public $last_position = 0;

    private $positionService;

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'position',
    );

    public function setPositionService(\Pix\SortableBehaviorBundle\Services\PositionHandler $positionHandler)
    {
        $this->positionService = $positionHandler;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        // ...
        $collection->add('move', $this->getRouterIdParameter().'/move/{position}');
    }

}
