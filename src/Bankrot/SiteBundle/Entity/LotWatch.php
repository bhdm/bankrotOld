<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="lot_watches")
 */
class LotWatch
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity="Lot")
     */
    private $lot;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $cutOffPrice;

    /**
     * @ORM\Column(type="date")
     */
    private $day;

    public function isTargetPeriod()
    {
        return (new \DateTime())->format('Y-m-d') === $this->getDay()->format('Y-m-d');
    }

    public function isControlPeriod()
    {
        $now = time();
        $prevDay = (new \DateTime())->getTimestamp() - 86400;
        $cryticalDay = $prevDay -= 86400 * 5;

        return $now >= $cryticalDay && $now <= $prevDay;
    }

    public function isReportingPeriod()
    {
        return time() > (new \DateTime())->getTimestamp() - 86400 * 6;
    }

    public function getId() { return $this->id; }

    public function setOwner(User $owner) { $this->owner = $owner; }

    public function getOwner() { return $this->owner; }

    public function setLot(Lot $lot) { $this->lot = $lot; }

    public function getLot() { return $this->lot; }

    public function setPrice($price) { $this->price = $price; }

    public function getPrice() { return $this->price; }

    public function setCutOffPrice($cutOffPrice) { $this->cutOffPrice = $cutOffPrice; }

    public function getCutOffPrice() { return $this->cutOffPrice; }

    public function setDay($day) { $this->day = $day; }

    public function getDay() { return $this->day; }
}
