<?php

namespace Lebed\VideoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Lebed\VideoBundle\Entity\Image;
use Symfony\Component\Yaml\Yaml;

class LoadImageData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $images = Yaml::parse(file_get_contents(__DIR__.'/Data/Image.yml'));

        foreach ($images as $key => $imageData) {
            $image = new Image();
            $image->setTitle('dgff');
            $image->setThumblnail($imageData['thumblnail']);
            $image->setSrc($imageData['thumblnail']);
            $manager->persist($image);
            $this->addReference($key, $image);
        }
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 5; // the order in which fixtures will be loaded
    }
}