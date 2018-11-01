<?php


namespace AppBundle\Controller\API;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/zone")
 */
class ZoneController extends ApiController
{

    /**
     * @Route("/list", name="app_api_zone_list", options={"expose"=true})
     * @Method("GET")
     * @ApiDoc(
     *     resource=true,
     *     section="Zone",
     *     description="Zone list"
     * )
     * @return Response
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Zone')->findAll();
        $entities  = $this->get('app.formatter.zone')->formatAll($entities);

        return $this->prepareJsonResponse($entities);
    }



}