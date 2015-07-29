<?php

namespace Bankrot\ParserBundle\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity()
 * @Table(name="content_groups")
 */
class ContentGroup
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
    private $name;

    public function getId() { return $this->id; }

    public function setName($name) { $this->name = $name; }

    public function getName() { return $this->name; }
}