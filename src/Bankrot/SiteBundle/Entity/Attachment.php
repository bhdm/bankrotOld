<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @ORM\Table(name="attachments")
 * @Gedmo\Uploadable()
 */
class Attachment
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Lot", inversedBy="attachments")
     */
    private $lot;

    /**
     * @ORM\Column()
     * @Gedmo\UploadableFilePath()
     */
    private $path;

    /**
     * @ORM\Column()
     * @Gedmo\UploadableFileName()
     */
    private $name;

    /**
     * @ORM\Column(name="mime_type")
     * @Gedmo\UploadableFileMimeType()
     */
    private $mimeType;

    /**
     * @ORM\Column(type="decimal")
     * @Gedmo\UploadableFileSize()
     */
    private $size;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    public function getId() { return $this->id; }

    public function setLot(Lot $lot) { $this->lot = $lot; }

    public function getLot() { return $this->lot; }

    public function setPath($path) { $this->path = $path; }

    public function getPath() { return $this->path; }

    public function setName($name) { $this->name = $name; }

    public function getName() { return $this->name; }

    public function setMimeType($mimeType) { $this->mimeType = $mimeType; }

    public function getMimeType() { return $this->mimeType; }

    public function setSize($size) { $this->size = $size; }

    public function getSize() { return $this->size; }

    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; }

    public function getCreatedAt() { return $this->createdAt; }
}
