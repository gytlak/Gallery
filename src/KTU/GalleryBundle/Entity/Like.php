<?php

namespace KTU\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* ObjectLike
*
* @ORM\Entity
* @ORM\Table(name="likes")
*/
class Like {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \KTU\GalleryBundle\Entity\Photo
     *
     * @ORM\ManyToOne(targetEntity="KTU\GalleryBundle\Entity\Photo", inversedBy="likes", cascade={"persist"})
     * @ORM\JoinColumn(name="photo_id", onDelete="CASCADE")
     */
    private $photoId;

    /**
     * @var string
     *
     * @ORM\Column(name="user_ip", type="string", length=255)
     */
    private $userIp;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    private $updated;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    private $created;


    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
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
     * @param \KTU\GalleryBundle\Entity\Photo $photoId
     */
    public function setPhotoId($photoId)
    {
        $this->photoId = $photoId;
    }

    /**
     * @return \KTU\GalleryBundle\Entity\Photo
     */
    public function getPhotoId()
    {
        return $this->photoId;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $userIp
     */
    public function setUserIp($userIp)
    {
        $this->userIp = $userIp;
    }

    /**
     * @return mixed
     */
    public function getUserIp()
    {
        return $this->userIp;
    }

}