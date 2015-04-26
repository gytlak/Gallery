<?php

namespace KTU\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Photo
 *
 * @ORM\Table(name="photos")
 * @ORM\Entity
 * @Vich\Uploadable
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
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="KTU\GalleryBundle\Entity\Album", inversedBy="photos")
     * @ORM\JoinTable(name="albums_photos")
     */
    private $albums;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(name="short_description", type="string", length=255)
     */
    private $shortDescription;

    /**
     * @Assert\Image
     * @Vich\UploadableField(mapping="photo", fileNameProperty="photoUrl")
     *
     * @var File $photo
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_url", type="string", length=255)
     */
    private $photoUrl;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="KTU\GalleryBundle\Entity\Like", mappedBy="photoId")
     */
    private $likes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="KTU\GalleryBundle\Entity\Comment", mappedBy="photoId")
     */
    private $comments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="KTU\GalleryBundle\Entity\Tag", inversedBy="photos", cascade={"persist"})
     * @ORM\JoinTable(name="photos_tags",
     *      joinColumns={@ORM\JoinColumn(name="Photo_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="Tag_name", referencedColumnName="name")}
     *      )
     */
    private $tags;

    /**
     * Creates a Doctrine Collection for albums.
     */
    public function __construct()
    {
        $this->albums = new \Doctrine\Common\Collections\ArrayCollection();
        $this->likes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * What is shown in a selection list
     */
    public function __toString()
    {
        return "{$this->getName()}";
    }

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
     * Add albums
     *
     * @param \KTU\GalleryBundle\Entity\Album $albums
     * @return Photo
     */
    public function addAlbum(\KTU\GalleryBundle\Entity\Album $albums)
    {
        $this->albums[] = $albums;

        return $this;
    }

    /**
     * Set albums
     *
     * @param \Doctrine\Common\Collections\Collection $albums
     */
    public function setAlbums($albums)
    {
        $this->albums = $albums;
    }

    /**
     * Get albums
     *
     * @return \KTU\GalleryBundle\Entity\Album
     */
    public function getAlbums()
    {
        return $this->albums;
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
     * Set userId
     *
     * @param \KTU\GalleryBundle\Entity\User $userId
     * @return Photo
     */
    public function setUserId(\KTU\GalleryBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return \KTU\GalleryBundle\Entity\User
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\File $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photoUrl
     */
    public function setPhotoUrl($photoUrl)
    {
        $this->photoUrl = $photoUrl;
    }

    /**
     * @return string
     */
    public function getPhotoUrl()
    {
        return $this->photoUrl;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Remove albums
     *
     * @param \KTU\GalleryBundle\Entity\Album $albums
     */
    public function removeAlbum(\KTU\GalleryBundle\Entity\Album $albums)
    {
        $this->albums->removeElement($albums);
    }

    /**
     * Add likes
     *
     * @param \KTU\GalleryBundle\Entity\Like $likes
     * @return Photo
     */
    public function addLike(\KTU\GalleryBundle\Entity\Like $likes)
    {
        $this->likes[] = $likes;
    
        return $this;
    }

    /**
     * Remove likes
     *
     * @param \KTU\GalleryBundle\Entity\Like $likes
     */
    public function removeLike(\KTU\GalleryBundle\Entity\Like $likes)
    {
        $this->likes->removeElement($likes);
    }

    /**
     * Add comments
     *
     * @param \KTU\GalleryBundle\Entity\Comment $comments
     * @return Photo
     */
    public function addComment(\KTU\GalleryBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \KTU\GalleryBundle\Entity\Comment $comments
     */
    public function removeComment(\KTU\GalleryBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Add tag
     *
     * @param \KTU\GalleryBundle\Entity\Tag $tag
     *
     * @return Photo
     */
    public function addTag(\KTU\GalleryBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \KTU\GalleryBundle\Entity\Tag $tag
     */
    public function removeTag(\KTU\GalleryBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }
}
