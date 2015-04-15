<?php
namespace KTU\GalleryBundle\Service;


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use KTU\GalleryBundle\Entity\Photo;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PhotoService
{

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $entityManager;

    /**
     * @var null
     */
    protected $photos = null;

    /**
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * Gets photos collection by album id.
     * Throws exception if album not found.
     *
     * @param $id
     * @param $album
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos($id, &$album)
    {
        if(!$this->photos) {
            $album = $this->entityManager->getRepository('KTUGalleryBundle:Album')->find($id);

            if (!$album) {
                throw new NotFoundHttpException('No album found for id '.$id);
            }

            $this->photos = $album->getPhotos();
        }

        return $this->photos;
    }

    /**
     * Gets photo object by photo id. Throws exception if not found.
     *
     * @param $id
     * @return \KTU\GalleryBundle\Entity\Photo
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getPhoto($id)
    {
        $photo = $this->entityManager->getRepository('KTUGalleryBundle:Photo')->find($id);

        if (!$photo) {
            throw new NotFoundHttpException('No photo found for id '.$id);
        }

        return $photo;
    }

    /**
     * Deletes photo by photo id.
     * Checks if user has right to delete it.
     *
     * @param $id
     * @param $user
     * @param $admin
     * @return bool
     */
    public function deletePhoto($id, $user, $admin)
    {
        $photo = $this->entityManager->getRepository('KTUGalleryBundle:Photo')->find($id);

        if (!$photo) {
            return false;
        } else if ($photo->getUserId() == $user || $admin) {
            try {
                $this->entityManager->remove($photo);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * Gets photo object by photo id and returns it. Also checks if user can modify it.
     *
     * @param $id
     * @param $user
     * @param $admin
     * @return \KTU\GalleryBundle\Entity\Photo|null
     */
    public function getUserPhoto(&$id, $user, $admin)
    {
        $photo = $this->entityManager->getRepository('KTUGalleryBundle:Photo')->find($id);

        if ($photo && ($photo->getUserId() == $user || $admin)) {
            return $photo;
        }

        $id = 0;
        return null;
    }
}
