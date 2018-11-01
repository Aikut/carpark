<?php

namespace MainBundle\Controller;

use AppBundle\Entity\Car;
use AppBundle\Entity\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/session")
 */
class SessionController extends Controller
{
    /**
     * @Route("/create/{zoneId}", name="session_create")
     */
    public function createAction($zoneId)
    {
        $em = $this->getDoctrine()->getManager();
        $zone = $em->getRepository('AppBundle:Zone')->find($zoneId);

        if(!$zone){
            throw $this->createNotFoundException('Unable to find entity.');
        }

        $session = new Session();
        $session->setUser($this->getUser());
        $session->setZone($zone);

        $em->persist($session);
        $em->flush();

        return $this->redirectToRoute('session_new_car', array('sessionId' => $session->getId()));
    }

    /**
     * @Route("/add-car/{sessionId}", name="session_new_car")
     */
    public function newAction($sessionId)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $em->getRepository('AppBundle:Session')->find($sessionId);

        if(!$session){
            throw $this->createNotFoundException('Unable to find entity.');
        }

        return $this->render('MainBundle:Session:new.html.twig', array(
            'session' => $session
        ));
    }


    /**
     * @Route("/add-car/{id}/{carNumber}/{breaker}",
     *     name="session_add_car", options={"expose"=true})
     *
     */
    public function addCarAction($id, $carNumber, $breaker)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $em->getRepository('AppBundle:Session')->find($id);

        if ($session){
            $car = new Car();
            $car->setTitle($carNumber);
            $car->setBreaker($breaker);
            $car->setSession($session);
            $car->setUser($this->getUser());
            $em->persist($car);
            $em->flush();
        }

        $data = array('cars' => sizeof($session->getCars()));

        return new JsonResponse($data);
    }

    /**
     * @Route("/close/{id}",
     *     name="session_close", options={"expose"=true})
     *
     */
    public function closeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Session')->find($id);
        if (!$entity->getClosed()){
            $entity->setClosed(true);
            $entity->setClosedAt(new \DateTime());
            $em->persist($entity);
            $em->flush();
        }
        return $this->redirectToRoute('zone_info', array('id' => $entity->getZone()->getId()));
    }

    /**
     * @Route("/my-sessions/list",
     *     name="sessions_by_user", options={"expose"=true})
     *
     */
    public function sessionsByUserAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sessions = $em->getRepository('AppBundle:Session')
            ->findBy(array('user' => $this->getUser()), array('created' => 'DESC'));

        $sessions  = $this->get('app.formatter.session')->formatAll($sessions);

        return $this->render('MainBundle:Session:sessions-by-user.html.twig', array(
            'sessions' => $sessions
        ));
    }
}
