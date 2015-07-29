<?php

namespace Bankrot\SiteBundle\DataFixtures\ORM;

use Bankrot\SiteBundle\Entity\DropRule;
use Bankrot\SiteBundle\Entity\Lot;
use Badcow\LoremIpsum\Generator;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadLotData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $lorem = new Generator();
        $categories = $manager->getRepository('AppBundle:Category')->findAll();
        $lotStatuses = $manager->getRepository('AppBundle:LotStatus')->findAll();

        for ($i = 0; $i < 500; $i++) {
            $this->loadSingle($manager, $lorem, $categories, $lotStatuses);
        }

        $manager->flush();
    }

    public function getOrder() { return 2; }

    private function loadSingle(ObjectManager $manager, Generator $lorem, array $categories, array $lotStatuses)
    {
        $lot = new Lot();
        $lot->setName($this->getRandomName($lorem));
        $lot->setCategory($categories[array_rand($categories)]);
        $lot->setLotStatus($lotStatuses[array_rand($lotStatuses)]);

        if (0 !== rand(0, 10)) {
            $lot->setOwner($this->getReference('user_user'));
            $lot->setUrl($this->getRandomUrl($lorem));
            $lot->setPhone($this->getRandomPhone());
            $lot->setPrice(rand(10000, 999999));
            $lot->setAddress($this->getRandomAddress($lorem));

            if (0 !== rand(0, 3)) {
                $lot->setDescription($this->getRandomDescription($lorem));
            }

            if (0 !== rand(0, 3)) {
                $lot->setInitialPrice($lot->getPrice() / 100 * rand(80, 90));

                switch (rand(0, 1)) {
                    case 0:
                        $lot->setCutOffPrice($lot->getInitialPrice() / 100 * rand(5, 10));
                        break;

                    case 1:
                        $lot->setCutOffPricePercent(rand(5, 10));
                        break;
                }

                switch (rand(0, 2)) {
                    case 0:
                        $lot->setDepositPrice($lot->getInitialPrice() / 100 * rand(10, 20));
                        break;

                    case 1:
                        $lot->setDepositPricePercent(rand(10, 20));
                        break;

                    case 2:
                        $lot->setDepositPricePercentCurrent(rand(10, 20));
                        break;
                }

                if (0 === rand(0, 3)) {
                    $lot->setBeginDate(new \DateTime('@'.rand(1420059600, 1441054800)));
                    $lot->setEndDate(new \DateTime('@'.($lot->getBeginDate()->getTimestamp() + 86400*(rand(90,240)))));
                } else {
                    for ($i = 0, $l = rand(0, 2); $i < $l; $i++) {
                        $dr = new DropRule();

                        if (0 === rand(0, 1)) {
                            $dr->setPeriod(rand(3, 10));
                        } else {
                            $dr->setPeriodWork(rand(3, 10));
                        }

                        if (0 === rand(0, 1)) {
                            $dr->setOrder(rand(10, 5000) / 100);
                        } else {
                            $dr->setOrderCurrent(rand(10, 5000) / 100);
                        }

                        $dr->setBeginDate(new \DateTime('@'.rand(1420059600, 1441054800)));  
                        $dr->setEndDate(new \DateTime('@'.($dr->getBeginDate()->getTimestamp() + 86400*(rand(7,30)))));

                        $lot->addDropRule($dr);
                    }
                }
            }
        }

        $manager->persist($lot);
    }

    private function getRandomName(Generator $lorem)
    {
        return implode(' ', $lorem->getRandomWords(rand(2, 5)));
    }

    private function getRandomUrl(Generator $lorem)
    {
        return 'http://' . $lorem->getRandomWords(1)[0] . '.example.com';
    }

    private function getRandomPhone()
    {
        return preg_replace('/^(\d{3})(\d{3})(\d{2})(\d{2})$/', '+7 ($1) $2-$3-$4', rand(1111111111, 9999999999));
    }

    private function getRandomAddress(Generator $lorem)
    {
        return implode(' ', $lorem->getRandomWords(rand(15, 20)));
    }

    private function getRandomDescription(Generator $lorem)
    {
        return implode(' ', $lorem->getRandomWords(rand(40, 60)));
    }
}
