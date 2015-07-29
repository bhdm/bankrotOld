<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Iphp\FileStoreBundle\Mapping\Annotation as FileStore;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ForumAnswer
 * @FileStore\Uploadable
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ForumAnswerRepository")
 */
class ForumAnswer extends BaseEntity
{

    /**
     * @Assert\NotBlank( message = "поле Ответ обязательно для заполнения" )
     * @ORM\Column(type="text")
     */
    protected $body;

    /**
     * @Assert\File( maxSize="3M")
     * @FileStore\UploadableField(mapping="files")
     * @ORM\Column(type="array", nullable=true)
     */
    protected $file;

    /**
     * @ORM\ManyToOne(targetEntity="ForumAnswer", inversedBy="by")
     */
    protected $for;

    /**
     * @ORM\OneToMany(targetEntity="ForumAnswer", mappedBy="for", cascade={"persist", "remove"})
     */
    protected $by;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="forumAnswers")
     */
    protected $author;

    /**
     * @ORM\ManyToOne(targetEntity="ForumQuestion", inversedBy="answers")
     */
    protected $question;

    /**
     * @ORM\ManyToOne(targetEntity="ForumTheme", inversedBy="answers")
     */
    protected $theme;



    /**
     *
     */
    public function __construct()
    {
        $this->by = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->body;
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
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $by
     */
    public function setBy($by)
    {
        $this->by = $by;
    }

    /**
     * @return mixed
     */
    public function getBy()
    {
        return $this->by;
    }

    public function addBy($by){
        $this->by[] = $by;
    }

    public function removeBy($by){
        $this->by->removeElement($by);
    }

    /**
     * @param mixed $for
     */
    public function setFor($for)
    {
        $this->for = $for;
    }

    /**
     * @return mixed
     */
    public function getFor()
    {
        return $this->for;
    }

    /**
     * @param mixed $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
//        if ($this->file){
//            $file = unserialize($this->file);
//        }else{
//            $file = null;
//        }
//        return $file;
    return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }



}
