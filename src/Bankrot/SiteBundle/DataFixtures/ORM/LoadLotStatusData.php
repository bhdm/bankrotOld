<?php

namespace Bankrot\SiteBundle\DataFixtures\ORM;

use Bankrot\SiteBundle\Entity\LotStatus;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadLotStatusData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ([
                     ['Отслеживание', false],
                     ['Подана заявка', false],
                     ['Торги приостановлены', false],
                     ['Лот куплен мной', true],
                     ['Лот куплен не мной', true],
                 ] as list($name, $isTrash)) {
            $lotStatus = new LotStatus();
            $lotStatus->setName($name);
            $lotStatus->setIsTrash($isTrash);

            $manager->persist($lotStatus);
        }

        $manager->flush();
    }

    public function getOrder() { return 1; }
}

