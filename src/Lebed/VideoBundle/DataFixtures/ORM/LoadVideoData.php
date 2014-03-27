<?php

namespace Lebed\VideoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Lebed\VideoBundle\Entity\Video;
use Symfony\Component\Yaml\Yaml;

class LoadVideoData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $videos = Yaml::parse(file_get_contents(__DIR__.'/Data/Video.yml'));

        foreach ($videos as $key => $videoData) {
            $video = new Video();
            $video->setTitle($videoData['title']);
            $video->setCategory($this->getReference($videoData['category']));
            $video->setAuthor($videoData['author']);
            $video->setYear($videoData['year']);
            $video->setType($this->getReference($videoData['type']));
            $video->setCountry($this->getReference($videoData['country']));
            $video->setLanguage($this->getReference($videoData['language']));
            $video->setDescription($videoData['description']);
            $video->setLink($videoData['link']);
            $manager->persist($video);
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