<?php

namespace Lebed\VideoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Lebed\VideoBundle\Entity\Category;
use Symfony\Component\Yaml\Yaml;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $categories = Yaml::parse(file_get_contents(__DIR__.'/Data/Category.yml'));

        foreach ($categories as $key => $categoryData) {
            $category = new Category();
            $category->setTitle($categoryData['title']);
            $category->setDescription($categoryData['description']);

            if (isset($categoryData['parent']))
            {
                $category->setParent($this->getReference($categoryData['parent']));
            }

            $this->addReference($key, $category);

            $manager->persist($category);
        }
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4; // the order in which fixtures will be loaded
    }
}