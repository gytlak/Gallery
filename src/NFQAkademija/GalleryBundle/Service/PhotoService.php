<?php
namespace NFQAkademija\GalleryBundle\Service;


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use NFQAkademija\GalleryBundle\Entity\Photo;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PhotoService
{

    /** @var EntityManager */
    protected $entityManager;

    protected $photos = null;

    public function __construct(ObjectManager $em)
    {
        $this->entityManager = $em;
    }

    public function getPhotos($id)
    {
        if(!$this->photos) {
            $album = $this->entityManager->getRepository('NFQAkademijaGalleryBundle:Album')->find($id);

            $this->photos = $album->getPhoto();
        }

        return $this->photos;
    }

    public function deletePhoto($id)
    {
        $photo = $this->entityManager->getRepository('NFQAkademijaGalleryBundle:Photo')->find($id);

        if (!$photo) {
            throw new NotFoundHttpException('No photo found for id '.$id);
        }

        $this->entityManager->remove($photo);
        $this->entityManager->flush();
    }

    public function setPhoto(&$id)
    {
        $photo = $this->entityManager->getRepository('NFQAkademijaGalleryBundle:Photo')->find($id);

        if (!$photo) {
            $photo = new Photo();
            $id = 0;
        }

        return $photo;
    }
}