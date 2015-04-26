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
     * @var string
     *
     * @ORM\Id
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
