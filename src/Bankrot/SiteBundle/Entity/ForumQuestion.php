<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ForumQuestion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ForumQuestionRepository")
 */
class ForumQuestion extends BaseEntity
{
    /**
     * @Assert\NotBlank( message = "Заголовок вопроса обязателен для заполнения" )
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $body;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="forumQuestions")
     */
    protected $author;

    /**
     * @ORM\ManyToOne(targetEntity="ForumTheme", inversedBy="questions")
     */
    protected $theme;

    /**
     * @ORM\OneToMany(targetEntity="ForumAnswer", mappedBy="question", cascade={"persist", "remove"})
     */
    protected $answers;

    /**
     *
     */
    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->title;
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
     * @param mixed $answers
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;
    }

    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    public function addAnswer($answer){
        $this->answers[] = $answer;
    }

    public function removeAnswer($answer){
        $this->answers->removeElement($answer);
    }


}
