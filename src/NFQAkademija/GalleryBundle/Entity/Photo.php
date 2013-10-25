<?php

namespace NFQAkademija\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Photo
 *
 * @ORM\Table(name="photos")
 * @ORM\Entity
 */
class Photo
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
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="albumId", type="integer")
     */
    private $albumId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(name="shortDescription", type="string", length=255)
     */
    private $shortDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="photoDate", type="datetime")
     */
    private $photoDate;

    /**
     * @var string
     *
     * @ORM\Column(name="photoUrl", type="string", length=255)
     */
    private $photoUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbUrl", type="string", length=255)
     */
    private $thumbUrl;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set albumId
     *
     * @param integer $albumId
     * @return Photo
     */
    public function setAlbumId($albumId)
    {
        $this->albumId = $albumId;
    
        return $this;
    }

    /**
     * Get albumId
     *
     * @return integer 
     */
    public function getAlbumId()
    {
        return $this->albumId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Photo
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Photo
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Photo
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     * @return Photo
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    
        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string 
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set photoDate
     *
     * @param \DateTime $photoDate
     * @return Photo
     */
    public function setPhotoDate($photoDate)
    {
        $this->photoDate = $photoDate;
    
        return $this;
    }

    /**
     * Get photoDate
     *
     * @return \DateTime 
     */
    public function getPhotoDate()
    {
        return $this->photoDate;
    }

    /**
     * Set photoUrl
     *
     * @param string $photoUrl
     * @return Photo
     */
    public function setPhotoUrl($photoUrl)
    {
        $this->photoUrl = $photoUrl;
    
        return $this;
    }

    /**
     * Get photoUrl
     *
     * @return string 
     */
    public function getPhotoUrl()
    {
        return $this->photoUrl;
    }

    /**
     * Set thumbUrl
     *
     * @param string $thumbUrl
     * @return Photo
     */
    public function setThumbUrl($thumbUrl)
    {
        $this->thumbUrl = $thumbUrl;
    
        return $this;
    }

    /**
     * Get thumbUrl
     *
     * @return string 
     */
    public function getThumbUrl()
    {
        return $this->thumbUrl;
    }

    /**
     * Set userId
     *
     * @param \NFQAkademija\GalleryBundle\Entity\User $userId
     * @return Photo
     */
    public function setUserId(\NFQAkademija\GalleryBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return \NFQAkademija\GalleryBundle\Entity\User 
     */
    public function getUserId()
    {
        return $this->userId;
    }
}