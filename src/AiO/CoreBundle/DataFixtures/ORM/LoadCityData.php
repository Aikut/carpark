<?php

namespace AiO\CoreBundle\DataFixtures\ORM;


use AppBundle\Entity\City;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCityData implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->persistPages($manager);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * @param ObjectManager $manager
     */

    private function persistPages(ObjectManager $manager)
    {
        $counter = 0;
        foreach ($this->pages as $a) {
            $page = new City();
            $page->setTitle($a['title']);
            $manager->persist($page);
            if ($counter % 10 == 0) {
                $manager->flush();
            }
            $counter++;
        }
        $manager->flush();
    }


    private $pages = [
        ["title" => "Бишкек"]
        , ["title" => "Ош"]
        , ["title" => "Баткен"]
        , ["title" => "Жалалабад"]
        , ["title" => "Нарын"]
        , ["title" => "Талас"]
        , ["title" => "Каракол"]
    ];
}