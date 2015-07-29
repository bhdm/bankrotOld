<?php

namespace Bankrot\SiteBundle\DataFixtures\ORM;

use Bankrot\SiteBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ([
                     'Автомобили и техника',
                     'Дебиторская задолженность',
                     'Недвижимость',
                     'Товары и материалы',
                     'Ценные бумаги',
                     'Прочее',
                 ] as $name) {
            $category = new Category();
            $category->setName($name);

            $manager->persist($category);
        }

        $manager->flush();
    }

    public function getOrder() { return 1; }
}
