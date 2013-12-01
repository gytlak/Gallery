<?php
namespace NFQAkademija\GalleryBundle\Service;


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use NFQAkademija\GalleryBundle\Entity\Album;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AlbumService
{

    /** @var EntityManager */
    protected $entityManager;

    protected $albums = null;

    public function __construct(ObjectManager $em)
    {
        $this->entityManager = $em;
    }

    public function getAlbums()
    {
        if(!$this->albums) {
            $this->albums = $this->entityManager->getRepository('NFQAkademijaGalleryBundle:Album')
                ->findBy(array(), array('id' => 'DESC'), 10);
        }

        return $this->albums;
    }

    public function deleteAlbum($id)
    {
        $album = $this->entityManager->getRepository('NFQAkademijaGalleryBundle:Album')->find($id);

        if (!$album) {
            throw new NotFoundHttpException('No album found for id '.$id);
        }

        $this->entityManager->remove($album);
        $this->entityManager->flush();
    }

    public function getAlbum(&$id)
    {
        $album = $this->entityManager->getRepository('NFQAkademijaGalleryBundle:Album')->find($id);

        if (!$album) {
            $album = new Album();
            $id = 0;
        }

        return $album;
    }
}