<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/main/chart")
 */
class HomeController extends Controller
{
    /**
     * @Route("", name="chart_index")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('chart',array('id'=>1));
    }

}
