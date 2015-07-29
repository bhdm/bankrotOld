<?php

namespace Bankrot\SiteBundle\DataFixtures\ORM;

use Bankrot\SiteBundle\Entity\LotWatch;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadLotWatchData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $conn = $manager->getConnection();

        $stmt = $conn->prepare('select id from lots');
        $stmt->execute();

        $lotIds = [];

        while ($lotId = $stmt->fetchColumn()) {
            $lotIds[] = (int)$lotId;
        }

        $stmt = $conn->prepare('select id from users');
        $stmt->execute();

        $usrIds = [];

        while ($usrId = $stmt->fetchColumn()) {
            $usrIds[] = (int)$usrId;
        }

        for ($i = 0, $l = count($lotIds) * count($usrIds); $i < $l; $i++) {
            $lot = $manager->getRepository('AppBundle:Lot')->find($lotIds[array_rand($lotIds)]);

            if ($lot->getBeginDate()) {
                if (0 === rand(0, 2)) {
                    $lw = new LotWatch();
                    $lw->setOwner($manager->getRepository('AppBundle:User')->find($usrIds[array_rand($usrIds)]));
                    $lw->setLot($lot);
                    $lw->setPrice(rand(0, 1000000));
                    $lw->setCutOffPrice(rand(10, 5000));
                    $lw->setDay(new \DateTime('@'.rand(
                        $lot->getBeginDate()->getTimestamp(),
                        $lot->getEndDate()->getTimestamp()
                    )));

                    $manager->persist($lw);
                }
            }
        }

        $manager->flush();
    }

    public function getOrder() { return 3; }
}

