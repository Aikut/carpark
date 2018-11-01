<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="main_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Zone')->findAll();

        $entities  = $this->get('app.formatter.zone')->formatAll($entities);


        return $this->render('MainBundle:Main:index.html.twig', array(
            'entities' => $entities
        ));
    }
}
