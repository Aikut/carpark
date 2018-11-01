<?php

namespace AiO\CoreBundle\Controller;

use Pix\SortableBehaviorBundle\Controller\SortableAdminController;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class BaseAdminController extends SortableAdminController
{

}
