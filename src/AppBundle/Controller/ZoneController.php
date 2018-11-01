<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/zone/map")
 */
class ZoneController extends Controller
{
    /**
     * @Route("", name="zone_map")
     * @Template()
     */
    public function mapAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Zone')->findAll();

        $entities  = $this->get('app.formatter.zone')->formatAll($entities);

        return array('entities' => $entities);
    }

}
