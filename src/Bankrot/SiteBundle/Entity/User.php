<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @Entity()
 * @Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @Column(type="integer")
     * @Id()
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="datetime", nullable=true)
     */
    protected $subscriptionDate;

    /**
     * @ORM\OneToMany(targetEntity="ForumQuestion", mappedBy="author")
     */
    protected $forumQuestions;

    /**
     * @ORM\OneToMany(targetEntity="Lot", mappedBy="owner")
     */
    private $lots;

    /**
     * @ORM\OneToMany(targetEntity="ForumAnswer", mappedBy="author")
     */
    protected $forumAnswers;

    public function __construct(){
        parent::__construct();
        $this->forumQuestions = new ArrayCollection();
        $this->forumAnswers = new ArrayCollection();
        $this->lots = new ArrayCollection();
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getForumQuestions()
    {
        return $this->forumQuestions;
    }

    /**
     * @param mixed $forumQuestions
     */
    public function setForumQuestions($forumQuestions)
    {
        $this->forumQuestions = $forumQuestions;
    }

    /**
     * @return mixed
     */
    public function getForumAnswers()
    {
        return $this->forumAnswers;
    }

    /**
     * @param mixed $forumAnswers
     */
    public function setForumAnswers($forumAnswers)
    {
        $this->forumAnswers = $forumAnswers;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionDate()
    {
        return $this->subscriptionDate;
    }

    /**
     * @param mixed $subscriptionDate
     */
    public function setSubscriptionDate($subscriptionDate)
    {
        $this->subscriptionDate = $subscriptionDate;
    }

    public function addLot(Lot $lot) { $this->lots[] = $lot; }

    public function removeLot(Lot $lot) { $this->lots->removeElement($lot); }

    public function getLots() { return $this->lots; }

}