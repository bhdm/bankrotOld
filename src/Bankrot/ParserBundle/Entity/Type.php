<?php

namespace Bankrot\ParserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity()
 * @Table(name="types")
 */
class Type
{
    /**
     * @Column(type="integer")
     * @Id()
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(unique=true)
     */
    private $name;

    /**
     * @OneToMany(targetEntity="Lot", mappedBy="type")
     */
    private $lots;

    public function __construct()
    {
        $this->areas = new ArrayCollection();
    }

    public function getId() { return $this->id; }

    public function setName($name) { $this->name = $name; }

    public function getName() { return $this->name; }

    public function addLot(Lot $lot) { $this->lots[] = $lot; }

    public function removeLot(Lot $lot) { $this->lots->removeElement($lot); }
}