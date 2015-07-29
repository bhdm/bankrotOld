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
 * @Table(name="attrs")
 */
class Attr
{
    /**
     * @Column(type="integer")
     * @Id()
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Lot", inversedBy="attrs", cascade={"all"})
     */
    private $lot;

    /**
     * @ManyToOne(targetEntity="AttrGroup", cascade={"all"})
     */
    private $group;

    /**
     * @Column()
     */
    private $val;

    public function getId() { return $this->id; }

    public function setLot(Lot $lot) { $this->lot = $lot; }

    public function getLot() { return $this->lot; }

    public function setGroup(AttrGroup $group) { $this->group = $group; }

    public function getGroup() { return $this->group; }

    public function setVal($val) { $this->val = $val; }

    public function getVal() { return $this->val; }
}