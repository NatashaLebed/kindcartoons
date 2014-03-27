<?php

namespace Lebed\VideoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Lebed\VideoBundle\Entity\Language;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadLanguageData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ru = new Language();
        $ru->setName('Русский');

        $ua = new Language();
        $ua->setName('Английкий');

        $en = new Language();
        $en->setName('Украинский');

        $manager->persist($ru);
        $manager->persist($ua);
        $manager->persist($en);

        $manager->flush();

        $this->addReference('ru', $ru);
        $this->addReference('ua', $ua);
        $this->addReference('en', $en);

    }

    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}