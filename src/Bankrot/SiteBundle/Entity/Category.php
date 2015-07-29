<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="categories")
 */
class Category
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(unique=true)
     */
    private $name;

    public function __toString() { return $this->name; }

    public function getId() { return $this->id; }

    public function setName($name) { $this->name = $name; }

    public function getName() { return $this->name; }
}
