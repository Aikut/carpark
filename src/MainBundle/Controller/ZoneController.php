<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/zone",)
 */
class ZoneController extends Controller
{
    /**
     * @Route("/info/{id}", name="zone_info")
     */
    public function infoAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Zone')->find($id);
        $entities = $em->getRepository('AppBundle:Zone')->findAll();

        if(!$entity){
            throw $this->createNotFoundException('Unable to find entity.');
        }

        $sessions = $em->getRepository('AppBundle:Session')
            ->createQueryBuilder('s')
            ->where('s.zone = :zone')
            ->setParameter('zone', $entity)
            ->setFirstResult(0)
            ->setMaxResults(15)
            ->orderBy('s.created', 'DESC')
            ->getQuery()->getResult();

        $sessions  = $this->get('app.formatter.session')->formatAll($sessions);


        return $this->render('MainBundle:Zone:info.html.twig', array(
            'entity' => $entity,
            'entities' => $entities,
            'sessions' => $sessions
        ));
    }

}
