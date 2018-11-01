<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TimeCar;
use AppBundle\Entity\Zone;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/chart/")
 */
class ChartController extends Controller
{

    /**
     * @Route("left/menu", name="left_menu")
     */
    public function leftMenuAction($type)
    {

        $zone = $this->getDoctrine()->getRepository('AppBundle:Zone')->findAll();

        return $this->render('@App/Chart/leftMenu.html.twig', array(
            'zone' => $zone,
            'type' => $type
            ));
    }

    /**
     * @Route("{zone}",defaults={"zone"=1}, name="chart")
     */
    public function chartsAction(Zone $zone)
    {

        $session = $this->getDoctrine()->getRepository('AppBundle:Session')->findByZone($zone);

        return $this->render(
            '@App/Chart/charts.html.twig',
            array(
                'session' => $session,
                'zone'    => $zone,
            )
        );
    }

    /**
     * @Route("by/car/{zone}",defaults={"zone"=1}, name="chart_by_car")
     */
    public function chartByCarAction(Zone $zone)
    {
        $session = $this->getDoctrine()->getRepository('AppBundle:Session')->findByZone($zone);

        return $this->render(
            '@App/Chart/byCar.html.twig',
            array(
                array(
                    'session' => $session,
                    'zone'    => $zone,
                ),
            )
        );
    }

    /**
     * @Route("get/data", name="get_data")
     */
    public function dataAction(Zone $id)
    {
        $session = $this->getDoctrine()->getRepository('AppBundle:Session')->findByZone($id);

        return $this->render('@App/Chart/data.html.twig', array('session' => $session));
    }

    /**
     * @Route("generate/car/time", name="generate_car_time")
     */
    public function generateCarTimeAction()
    {
//        $timeCar = $this->getDoctrine()->getManager()
//            ->getRepository('AppBundle:Car')
//            ->createQueryBuilder('car')
//            ->select('COUNT(car.title)')
//            ->addSelect('car.title')
//            ->groupBy('car.title')
//            ->orderBy('car.title','ASC')
//            ->getQuery()
//            ->getResult();
        $em      = $this->getDoctrine()->getManager();
        $count   = 0;
        $carTime = $this->getDoctrine()->getRepository('AppBundle:TimeCar')->findAll();
//        if ($carTime == null) {
//            for ($i = 0; $i < 1000; $i++) {
//                $newCarTime = new TimeCar();
//                if ($i / 10 < 1) {
//                    $newCarTime->setCarNum("000".$i);
//                } elseif ($i % 10 < 10) {
//                    $newCarTime->setCarNum("00".$i);
//                }elseif ($i % 10 < 100) {
//                    $newCarTime->setCarNum("0".$i);
//                } else {
//                    $newCarTime->setCarNum("".$i);
//                }
//                $newCarTime->setTime('00:00');
//                $newCarTime->setZone(null);
//                $em->persist($newCarTime);
//                $em->flush();
//            }
//        }
        $zones = $this->getDoctrine()->getRepository('AppBundle:TimeCar')->findAll();
        foreach ($zones as $zone) {
            $sessions = $this->getDoctrine()->getRepository('AppBundle:Session')->findByZone($zone);
            foreach ($sessions as $session) {

            }
        }

        dump($carTime);
        die();
//        $test = null;
//        foreach ($cars as $item) {
//            if ($timeCar[])
//            $test->setCar($item->getTitle());
//            array_push($timeCar,$test);
//        }
//        dump($timeCar);
//        die();

    }
}
