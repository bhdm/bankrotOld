<?php

namespace Bankrot\ParserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity()
 * @Table(name="lots")
 */
class Lot
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
     * @Column()
     */
    private $number;

    /**
     * @ManyToOne(targetEntity="Area", inversedBy="lots")
     */
    private $area;

    /**
     * @ManyToOne(targetEntity="Debtor", inversedBy="lots")
     */
    private $debtor;

    /**
     * @ManyToOne(targetEntity="Type", inversedBy="lots")
     */
    private $type;

    /**
     * @ManyToOne(targetEntity="PriceType", inversedBy="lots")
     */
    private $priceType;

    /**
     * @ManyToOne(targetEntity="Status", inversedBy="lots")
     */
    private $status;

    /**
     * @Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Column(type="datetime")
     */
    private $bidAt;

    /**
     * @OneToMany(targetEntity="Attr", mappedBy="lot")
     */
    private $attrs;

    /**
     * @OneToMany(targetEntity="Cost", mappedBy="lot")
     */
    private $costs;

    /**
     * @OneToMany(targetEntity="Date", mappedBy="lot")
     */
    private $dates;

    /**
     * @OneToMany(targetEntity="Content", mappedBy="lot")
     */
    private $contents;

    public function __construct()
    {
        $this->attrs = new ArrayCollection();
        $this->costs = new ArrayCollection();
        $this->dates = new ArrayCollection();
        $this->contents = new ArrayCollection();
    }

    public function getId() { return $this->id; }

    public function setRemoteId($remoteId) { $this->remoteId = $remoteId; }

    public function getRemoteId() { return $this->remoteId; }

    public function setNumber($number) { $this->number = $number; }

    public function getNumber() { return $this->number; }

    public function setArea(Area $area) { $this->area = $area; }

    public function getArea() { return $this->area; }

    public function setDebtor(Debtor $debtor) { $this->debtor = $debtor; }

    public function getDebtor() { return $this->debtor; }

    public function setType(Type $type) { $this->type = $type; }

    public function getType() { return $this->type; }

    public function setPriceType(PriceType $priceType) { $this->priceType = $priceType; }

    public function getPriceType() { return $this->priceType; }

    public function setStatus(Status $status) { $this->status = $status; }

    public function getStatus() { return $this->status; }

    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; }

    public function getCreatedAt() { return $this->createdAt; }

    public function setBidAt($bidAt) { $this->bidAt = $bidAt; }

    public function getBidAt() { return $this->bidAt; }

    public function addAttr(Attr $attr) { $this->attrs->add($attr); }

    public function removeAttr(Attr $attr) { $this->attrs->removeElement($attr); }

    public function getAttrs() { return $this->attrs; }

    public function addCost(Cost $cost) { $this->costs->add($cost); }

    public function removeCost(Cost $cost) { $this->costs->removeElement($cost); }

    public function getCosts() { return $this->costs; }

    public function addDate(Date $date) { $this->dates->add($date); }

    public function removeDate(Date $date) { $this->dates->removeElement($date); }

    public function getDates() { return $this->dates; }

    public function addContent(Content $content) { $this->contents->add($content); }

    public function removeContent(Content $content) { $this->contents->removeElement($content); }

    public function getContents() { return $this->contents; }
}