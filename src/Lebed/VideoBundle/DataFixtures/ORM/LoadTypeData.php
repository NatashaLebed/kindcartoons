<?php

namespace Lebed\VideoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Lebed\VideoBundle\Entity\Type;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $film = new Type();
        $film->setName('Мультфильм');

        $serial = new Type();
        $serial->setName('Мультсериал');

        $manager->persist($film);
        $manager->persist($serial);
        $manager->flush();

        $this->addReference('film', $film);
        $this->addReference('serial', $serial);
    }

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}