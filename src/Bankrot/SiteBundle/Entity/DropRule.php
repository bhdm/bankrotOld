<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="drop_rules")
 */
class DropRule
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Lot", inversedBy="attachments")
     */
    private $lot;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $period;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $periodWork;

    /**
     * @ORM\Column(type="decimal", nullable=true, name="ordr", precision=4, scale=2)
     */
    private $order;

    /**
     * @ORM\Column(type="decimal", nullable=true, precision=4, scale=2)
     */
    private $orderCurrent;

    /**
     * @ORM\Column(type="date", name="begin_date")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $beginDate;

    /**
     * @ORM\Column(type="date", name="end_date")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $endDate;

    public function getId() { return $this->id; }

    public function setLot(Lot $lot) { $this->lot = $lot; }

    public function getLot() { return $this->lot; }

    public function setPeriod($period) { $this->period = $period; }

    public function getPeriod() { return $this->period; }

    public function setPeriodWork($periodWork) { $this->periodWork = $periodWork; }

    public function getPeriodWork() { return $this->periodWork; }

    public function setOrder($order) { $this->order = $order; }

    public function getOrder() { return $this->order; }

    public function setOrderCurrent($orderCurrent) { $this->orderCurrent = $orderCurrent; }

    public function getOrderCurrent() { return $this->orderCurrent; }

    public function setBeginDate($beginDate) { $this->beginDate = $beginDate; }

    public function getBeginDate() { return $this->beginDate; }

    public function setEndDate($endDate) { $this->endDate = $endDate; }

    public function getEndDate() { return $this->endDate; }
}
