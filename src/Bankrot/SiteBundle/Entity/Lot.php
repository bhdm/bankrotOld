<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Bankrot\SiteBundle\Entity\LotRepository")
 * @ORM\Table(name="lot")
 */
class Lot
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="lots")
     */
    protected $owner;

    /**
     * @ORM\ManyToOne(targetEntity="LotStatus")
     */
    protected $lotStatus;

    /**
     * @ORM\Column()
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @Assert\NotNull()
     */
    protected $category;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $url;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(nullable=true, type="decimal", precision=14, scale=2)
     * @Assert\Range(min=0)
     */
    protected $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(name="initial_price", nullable=true, type="decimal", precision=14, scale=2)
     * @Assert\Range(min=0)
     */
    protected $initialPrice;

    /**
     * @ORM\Column(name="cut_off_price", type="decimal", nullable=true, precision=14, scale=2)
     * @Assert\Range(min=0)
     */
    protected $cutOffPrice;

    /**
     * @ORM\Column(name="cut_off_price_percent", type="decimal", nullable=true, precision=4, scale=1)
     * @Assert\Range(min=0, max=100)
     */
    protected $cutOffPricePercent;

    /**
     * @ORM\Column(name="deposit_price", type="decimal", nullable=true, precision=14, scale=2)
     * @Assert\Range(min=0)
     */
    protected $depositPrice;

    /**
     * @ORM\Column(name="deposit_price_percent", type="decimal", nullable=true, precision=4, scale=1)
     * @Assert\Range(min=0, max=100)
     */
    protected $depositPricePercent;

    /**
     * @ORM\Column(name="deposit_price_percent_current", type="decimal", nullable=true, precision=4, scale=1)
     * @Assert\Range(min=0, max=100)
     */
    protected $depositPricePercentCurrent;

    /**
     * @ORM\Column(type="date", name="begin_date", nullable=true)
     * @Assert\Date()
     */
    protected $beginDate;

    /**
     * @ORM\Column(type="date", name="end_date", nullable=true)
     * @Assert\Date()
     */
    protected $endDate;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="Attachment", mappedBy="lot")
     */
    protected $attachments;

    /**
     * @ORM\OneToMany(targetEntity="DropRule", mappedBy="lot", cascade={"persist"})
     */
    protected $dropRules;

    public function __construct()
    {
        $this->attachments = new ArrayCollection();
        $this->dropRules = new ArrayCollection();
    }

    public function getId() { return $this->id; }

    public function setOwner(User $owner) { $this->owner = $owner; }

    public function getOwner() { return $this->owner; }

    public function setLotStatus(LotStatus $lotStatus = null) { $this->lotStatus = $lotStatus; }

    public function getLotStatus() { return $this->lotStatus; }

    public function setName($name) { $this->name = $name; }

    public function getName() { return $this->name; }

    public function setCategory(Category $category) { $this->category = $category; }

    public function getCategory() { return $this->category; }

    public function setUrl($url) { $this->url = $url; }

    public function getUrl() { return $this->url; }

    public function setPhone($phone) { $this->phone = $phone; }

    public function getPhone() { return $this->phone; }

    public function setPrice($price) { $this->price = $price; }

    public function getPrice() { return $this->price; }

    public function setAddress($address) { $this->address = $address; }

    public function getAddress() { return $this->address; }

    public function setDescription($description) { $this->description = $description; }

    public function getDescription() { return $this->description; }

    public function setInitialPrice($initialPrice) { $this->initialPrice = $initialPrice; }

    public function getInitialPrice() { return $this->initialPrice; }

    public function setCutOffPrice($cutOffPrice) { $this->cutOffPrice = $cutOffPrice; }

    public function getCutOffPrice() { return $this->cutOffPrice; }

    public function setCutOffPricePercent($cutOffPricePercent) { $this->cutOffPricePercent = $cutOffPricePercent; }

    public function getCutOffPricePercent() { return $this->cutOffPricePercent; }

    public function setDepositPrice($depositPrice) { $this->depositPrice = $depositPrice; }

    public function getDepositPrice() { return $this->depositPrice; }

    public function setDepositPricePercent($depositPricePercent) { $this->depositPricePercent = $depositPricePercent; }

    public function getDepositPricePercent() { return $this->depositPricePercent; }

    public function setDepositPricePercentCurrent($dppc) { $this->depositPricePercentCurrent = $dppc; }

    public function getDepositPricePercentCurrent() { return $this->depositPricePercentCurrent; }

    public function setBeginDate($beginDate) { $this->beginDate = $beginDate; }

    public function getBeginDate() { return $this->beginDate; }

    public function setEndDate($endDate) { $this->endDate = $endDate; }

    public function getEndDate() { return $this->endDate; }

    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; }

    public function getCreatedAt() { return $this->createdAt; }

    public function addAttachment(Attachment $attachment) { $this->attachments[] = $attachment; }

    public function removeAttachment(Attachment $attachment) { $this->attachments->removeElement($attachment); }

    public function getAttachments() { return $this->attachments; }

    public function addDropRule(DropRule $dropRule) { $dropRule->setLot($this); $this->dropRules[] = $dropRule; }

    public function removeDropRule(DropRule $dropRule) { $this->dropRules->removeElement($dropRule); }

    public function getDropRules() { return $this->dropRules; }

    public function setData($params){
        foreach ( $params as $name => $value){
            if (property_exists($this,$name)){
                $this->$name = $value;
            }
        }
        return true;
    }
}

