<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use AppBundle\Entity\Session;
use AppBundle\Entity\Zone;
use DateInterval;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/chart/parking/time")
 */
class ParkingTimeController extends Controller
{
    /**
     *
     * @Route("/{zone}",defaults={"zone"=1}, name="parking_by_zone")
     */
    public function chartsAction(Zone $zone)
    {
        $em = $this->getDoctrine()->getManager();
        $sessions = $em->getRepository('AppBundle:Session')
            ->findBy(array('zone' => $zone), array('created' => 'ASC'));



        // Сессиянын жабылганы жазылбай калса 30 минутада жабылды деп эсептейт
        for ($i = 0; $i < sizeof($sessions) - 1; $i++){

            if (!$sessions[$i]->getClosedAt()){

                $dt = $sessions[$i]->getCreated();
                $dt->add(new DateInterval('PT30M'));
                // 30 минута кошот же кийинки сессиянын башталыш убактысын алат
                $sessions[$i]->setClosedAt(min($dt, $sessions[$i+1]->getCreated()));
            }
        }

        // Акыркы сессиянын жабылыш убактысын текшерет
        if (sizeof($sessions) > 1 && !$sessions[sizeof($sessions)-1]->getClosedAt()){
            $dt = $sessions[sizeof($sessions)-1]->getCreated();
            $dt->add(new DateInterval('PT30M'));
            $sessions[sizeof($sessions)-1]->setClosedAt($dt);
        }

        /** @var $cars Car[] */
        $cars = $em->getRepository('AppBundle:Car')
            ->findByZone($zone);

        $checked = array();
        foreach ($cars as $car){
            $checked[$car->getTitle()] = false;
        }
        $data = $this->init();

        // Зонага кирген машиналардын баарын бирден текшерет
        foreach ($cars as $car){

            if ($checked[$car->getTitle()] == true) continue;

            $checked[$car->getTitle()] = true;

            $startTime = false;
            $closeTime = false;

            // Катар сессияда кошулган болсо убактысын кошуп кетет. Эгер кошулбасы убактысын токтотуп эсептейт
            foreach ($sessions as $session){

                $inSession = false;
                $closeTime = $session->getClosedAt();

                foreach ($session->getCars() as $scar){

                    if ($car->getTitle() == $scar->getTitle()){
                        $inSession = true;
                        if ($startTime == false){
                            $startTime = $session->getCreated();
                        }
                        break;
                    }
                }

                if ($inSession == false && $startTime != false){
                    $interval = $closeTime->diff($startTime);
                    $diff = $interval->format('%h') * 60 + $interval->format('%i');
                    $data = $this->count($data, $diff, $car->getTitle());
                    $startTime = false;
                }

            }

            // Акыркы сессияны карайт. Кошулган болсо эсептейт
            if ($startTime){
                $interval = $closeTime->diff($startTime);
                $diff = $interval->format('%h') * 60 + $interval->format('%i');
                $data = $this->count($data, $diff, $car->getTitle());
            }
        }


        return $this->render(
            '@App/Chart/parking.html.twig',
            array(
                'session' => $sessions,
                'zone'    => $zone,
                'data'    => $data
            )
        );
    }

    private function sortCars($cars)
    {
        for($i = 0; $i < sizeof($cars);$i++){
            for($j = 0; $j < sizeof($cars); $j++){
                if ($cars[$i] < $cars[$j]){
                    $a = $cars[$i];
                    $cars[$i] = $cars[$j];
                    $cars[$j] = $a;
                }
            }
        }
        return $cars;
    }

    private function init()
    {
        $data = array();

        $item = array(
            'time' => '1 ч.',
            'count' => 0,
            'cars' => array()
        );
        $data[] = $item;

        $item = array(
            'time' => '2 ч.',
            'count' => 0,
            'cars' => array()
        );
        $data[] = $item;

        $item = array(
            'time' => '3 ч.',
            'count' => 0,
            'cars' => array()
        );
        $data[] = $item;

        $item = array(
            'time' => '4 ч.',
            'count' => 0,
            'cars' => array()
        );
        $data[] = $item;

        $item = array(
            'time' => '5 ч.',
            'count' => 0,
            'cars' => array()
        );
        $data[] = $item;


        $item = array(
            'time' => '6 ч.',
            'count' => 0,
            'cars' => array()
        );
        $data[] = $item;

        $item = array(
            'time' => '7 ч.',
            'count' => 0,
            'cars' => array()
        );
        $data[] = $item;

        $item = array(
            'time' => '8 ч.',
            'count' => 0,
            'cars' => array()
        );
        $data[] = $item;

        $item = array(
            'time' => 'больше 8 ч.',
            'count' => 0,
            'cars' => array()
        );
        $data[] = $item;

        return $data;
    }

    private function count($data, $minute, $car)
    {
        if ($minute < 60){
            for ($i = 0; $i < sizeof($data); $i++){
                if ($data[$i]['time'] == '1 ч.'){
                    $data[$i]['count']++;
                    $data[$i]['cars'][] = $car;
                    return $data;
                }
            }
        }
        if ($minute < 120){
            for ($i = 0; $i < sizeof($data); $i++){
                if ($data[$i]['time'] == '2 ч.'){
                    $data[$i]['count']++;
                    $data[$i]['cars'][] = $car;
                    return $data;
                }
            }
        }
        if ($minute < 180){
            for ($i = 0; $i < sizeof($data); $i++){
                if ($data[$i]['time'] == '3 ч.'){
                    $data[$i]['count']++;
                    $data[$i]['cars'][] = $car;
                    return $data;
                }
            }
        }
        if ($minute < 240){
            for ($i = 0; $i < sizeof($data); $i++){
                if ($data[$i]['time'] == '4 ч.'){
                    $data[$i]['count']++;
                    $data[$i]['cars'][] = $car;
                    return $data;
                }
            }
        }
        if ($minute < 300){
            for ($i = 0; $i < sizeof($data); $i++){
                if ($data[$i]['time'] == '5 ч.'){
                    $data[$i]['count']++;
                    $data[$i]['cars'][] = $car;
                    return $data;
                }
            }
        }
        if ($minute < 360){
            for ($i = 0; $i < sizeof($data); $i++){
                if ($data[$i]['time'] == '6 ч.'){
                    $data[$i]['count']++;
                    $data[$i]['cars'][] = $car;
                    return $data;
                }
            }
        }
        if ($minute < 420){
            for ($i = 0; $i < sizeof($data); $i++){
                if ($data[$i]['time'] == '7 ч.'){
                    $data[$i]['count']++;
                    $data[$i]['cars'][] = $car;
                    return $data;
                }
            }
        }
        if ($minute < 480){
            for ($i = 0; $i < sizeof($data); $i++){
                if ($data[$i]['time'] == '8 ч.'){
                    $data[$i]['count']++;
                    $data[$i]['cars'][] = $car;
                    return $data;
                }
            }
        }
        if($minute >= 480){
            for ($i = 0; $i < sizeof($data); $i++){
                if ($data[$i]['time'] == 'больше 8 ч.'){
                    $data[$i]['count']++;
                    $data[$i]['cars'][] = $car;
                    return $data;
                }
            }
        }
    }

}
