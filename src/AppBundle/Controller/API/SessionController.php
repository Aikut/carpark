<?php
/**
 * Created by PhpStorm.
 * User: adilet
 * Date: 1/27/18
 * Time: 2:10 AM
 */

namespace AppBundle\Controller\API;

use AppBundle\Entity\Car;
use AppBundle\Entity\Session;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/session")
 */
class SessionController extends ApiController
{

    /**
     * @Route("/list/{id}", name="app_api_session_list", options={"expose"=true})
     * @Method("GET")
     * @ApiDoc(
     *     resource=true,
     *     section="Session",
     *     description="Session list by zone",
     *     requirements={
     *          {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="Zone id"}
     *     }
     * )
     * @return Response
     */
    public function listAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $zone = $em->getRepository('AppBundle:Zone')->find($id);
        $sessions = $em->getRepository('AppBundle:Session')
            ->createQueryBuilder('s')
            ->where('s.zone = :zone')
            ->setParameter('zone', $zone)
            ->setFirstResult(0)
            ->setMaxResults(10)
            ->orderBy('s.created', 'DESC')
            ->getQuery()->getResult();

        $sessions  = $this->get('app.formatter.session')->formatAll($sessions);
        $zone = $this->get('app.formatter.zone')->format($zone);

        $data = array('zone' => $zone, 'sessions' => $sessions);

        return $this->prepareJsonResponse($data);
    }


    /**
     * @Route("/create/{id}", name="app_api_session_create", options={"expose"=true})
     * @Method("GET")
     * @ApiDoc(
     *     resource=true,
     *     section="Session",
     *     description="Session create",
     *     requirements={
     *          {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="Zone id"}
     *     }
     * )
     * @return Response
     */
    public function createAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $zone = $em->getRepository('AppBundle:Zone')->find($id);
        $session = new Session();
        $session->setUser($this->getUser());
        $session->setZone($zone);

        $em->persist($session);
        $em->flush();

        $zone  = $this->get('app.formatter.zone')->format($zone);
        $session = $this->get('app.formatter.session')->format($session);

        $data = array(
            'zone' => $zone,
            'session' => $session
        );

        return $this->prepareJsonResponse($data);
    }

    /**
     * @Route("/add-car/{id}/{carNumber}/{breaker}", name="app_api_session_add_car", options={"expose"=true})
     * @Method("GET")
     * @ApiDoc(
     *     resource=true,
     *     section="Session",
     *     description="Session add car",
     *     requirements={
     *          {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="Session id"},
     *          {"name"="carNumber", "dataType"="string", "requirement"="\s+", "description"="Car number"},
     *          {"name"="breaker", "dataType"="boolean", "requirement"="\d+", "description"="Car is breaker"}
     *     }
     * )
     * @return Response
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

        return $this->prepareJsonResponse($data);
    }

    /**
     * @Route("/close/{id}", name="app_api_session_close", options={"expose"=true})
     * @Method("GET")
     * @ApiDoc(
     *     resource=true,
     *     section="Session",
     *     description="Session close",
     *     requirements={
     *          {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="Session id"}
     *     }
     * )
     * @return Response
     */
    public function closeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $em->getRepository('AppBundle:Session')->find($id);

        if ($session){

            $closedAt = new \DateTime();


            $result = $closedAt->format('d-m-Y H:i');


            $session->setClosed(true);
            $session->setClosedAt($closedAt);
            $session->setTitle($session->getTitle() . ' - ' . $result);

            $em->persist($session);
            $em->flush();

            return $this->prepareJsonResponse(1);
        }
        return $this->prepareJsonResponse(0);
    }

}