<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="lot_statuses")
 */
class LotStatus
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

    /**
     * @ORM\Column(type="boolean")
     */
    private $isTrash;

    public function __toString() { return $this->name; }

    public function getId() { return $this->id; }

    public function setName($name) { $this->name = $name; }

    public function getName() { return $this->name; }

    public function setIsTrash($isTrash) { $this->isTrash = $isTrash; }

    public function getIsTrash() { return $this->isTrash; }
}
