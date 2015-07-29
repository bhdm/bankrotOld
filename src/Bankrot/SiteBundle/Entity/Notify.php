<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Notify
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Notify extends BaseEntity
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $body;

    /**
     * @return mixed
     */
    public function getBody()
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


}
