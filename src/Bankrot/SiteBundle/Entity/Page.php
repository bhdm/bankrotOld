<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Page
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PageRepository")
 */
class Page extends BaseEntity
{
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank( message = "поле Заголовок обязательно для заполнения" )
     */
    protected $title;

    /**
     * @ORM\ManyToMany(targetEntity="Page", inversedBy="page")
     */
    protected $links;

    /**
     * @ORM\ManyToMany(targetEntity="Page", mappedBy="links")
     */
    protected $page;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $h1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $keywords;

    /**
     * @Assert\NotBlank( message = "поле URL обязательно для заполнения" )
     * @ORM\Column(type="string")
     */
    protected $url;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $body;

    public function __construct(){
        $this->links = new ArrayCollection();
    }

    public function getId(){
        return $this->id;
    }

    public function __toString(){
        return ''.$this->title;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return mixed
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getH1()
    {
        return $this->h1;
    }

    /**
     * @param mixed $h1
     */
    public function setH1($h1)
    {
        $this->h1 = $h1;
    }

    /**
     * @return mixed
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param mixed $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    public function addLink($link){
        $this->links[] = $link;
    }

    public function removeLink($link){
        $this->links->removeElement($link);
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }



}
