<?php
namespace NFQAkademija\GalleryBundle\Service;


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use NFQAkademija\GalleryBundle\Entity\Photo;
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
     *
     * @param $id
     * @param $album
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos($id, &$album)
    {
        if(!$this->photos) {
            $album = $this->entityManager->getRepository('NFQAkademijaGalleryBundle:Album')->find($id);
            $this->photos = $album->getPhotos();
        }

        return $this->photos;
    }

    /**
     * Gets photo object by photo id. Throws exception if not found.
     *
     * @param $id
     * @return \NFQAkademija\GalleryBundle\Entity\Photo
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getPhoto($id)
    {
        $photo = $this->entityManager->getRepository('NFQAkademijaGalleryBundle:Photo')->find($id);

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
        $photo = $this->entityManager->getRepository('NFQAkademijaGalleryBundle:Photo')->find($id);

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
     * Gets photo object by photo id and returns it.
     * If no photo is found, creates new photo object and returns it.
     *
     * @param $id
     * @param $user
     * @param $admin
     * @return \NFQAkademija\GalleryBundle\Entity\Photo
     */
    public function setPhoto(&$id, $user, $admin)
    {
        $photo = $this->entityManager->getRepository('NFQAkademijaGalleryBundle:Photo')->find($id);

        if ($photo && ($photo->getUserId() == $user || $admin)) {
            return $photo;
        }

        $photo = new Photo();
        $id = 0;

        return $photo;
    }
}