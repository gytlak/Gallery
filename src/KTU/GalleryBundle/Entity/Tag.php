<?php

namespace KTU\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Tag
 *
 * @ORM\Entity
 * @ORM\Table(name="tags")
 */
class Tag
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \KTU\GalleryBundle\Entity\Photo
     *
     * @ORM\ManyToOne(targetEntity="KTU\GalleryBundle\Entity\Photo", inversedBy="tags", cascade={"persist"})
     * @ORM\JoinColumn(name="photo_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $photo;

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \KTU\GalleryBundle\Entity\Photo $photo
     */
    public function setPhoto(Photo $photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return \KTU\GalleryBundle\Entity\Photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }

}