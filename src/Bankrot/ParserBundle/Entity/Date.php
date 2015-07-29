<?php

namespace Bankrot\ParserBundle\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity()
 * @Table(name="dates")
 */
class Date
{
    /**
     * @Column(type="integer")
     * @Id()
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Lot", inversedBy="dates", cascade={"all"})
     */
    private $lot;

    /**
     * @ManyToOne(targetEntity="DateGroup", cascade={"all"})
     */
    private $group;

    /**
     * @Column(type="datetime")
     */
    private $val;

    public function getId() { return $this->id; }

    public function setLot(Lot $lot) { $this->lot = $lot; }

    public function getLot() { return $this->lot; }

    public function setGroup(DateGroup $group) { $this->group = $group; }

    public function getGroup() { return $this->group; }

    public function setVal($val) { $this->val = $val; }

    public function getVal() { return $this->val; }
}