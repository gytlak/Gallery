<?php

namespace NFQAkademija\GalleryBundle\Entity;

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
     * @ORM\Column(name="tag", type="string", length=255)
     */
    private $tag;

    /**
     * @var \NFQAkademija\GalleryBundle\Entity\Photo
     *
     * @ORM\ManyToOne(targetEntity="NFQAkademija\GalleryBundle\Entity\Photo", inversedBy="tags", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="photo_id", onDelete="CASCADE")
     */
    private $photoId;

    /**
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
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
     * @param \NFQAkademija\GalleryBundle\Entity\Photo $photoId
     */
    public function setPhotoId($photoId)
    {
        $this->photoId = $photoId;
    }

    /**
     * @return \NFQAkademija\GalleryBundle\Entity\Photo
     */
    public function getPhotoId()
    {
        return $this->photoId;
    }


}