<?php

namespace Lebed\VideoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Lebed\VideoBundle\Entity\Country;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadCountryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $russian = new Country();
        $russian->setName('Русские');

        $soviet = new Country();
        $soviet->setName('Советские');

        $foreign = new Country();
        $foreign->setName('Зарубежные');

        $manager->persist($russian);
        $manager->persist($soviet);
        $manager->persist($foreign);

        $manager->flush();

        $this->addReference('russian', $russian);
        $this->addReference('soviet', $soviet);
        $this->addReference('foreign', $foreign);

    }

    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}