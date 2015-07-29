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
 * @Table(name="areas")
 */
class Area
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
    private $remoteId;

    /**
     * @Column(unique=true)
     */
    private $name;

    /**
     * @Column(type="string")
     */
    private $link;




    /**
     * @OneToMany(targetEntity="Lot", mappedBy="area")
     *
     */
    private $lots;

    public function __construct()
    {
        $this->areas = new ArrayCollection();
    }

    public function getId() { return $this->id; }

    public function setRemoteId($remoteId) { $this->remoteId = $remoteId; }

    public function getRemoteId() { return $this->remoteId; }

    public function setName($name) { $this->name = $name; }

    public function getName() { return $this->name; }

    public function addLot(Lot $lot) { $this->lots[] = $lot; }

    public function removeLot(Lot $lot) { $this->lots->removeElement($lot); }

    public function getLink() { return $this->link; }

    public function setLink($link) { $this->link = $link; }
}