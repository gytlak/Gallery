<?php
namespace NFQAkademija\GalleryBundle\Service;


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use NFQAkademija\GalleryBundle\Entity\Album;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AlbumService
{

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $entityManager;

    /**
     * @var null
     */
    protected $albums = null;

    /**
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @return array|null
     */
    public function getAlbums()
    {
        if(!$this->albums) {
            $this->albums = $this->entityManager->getRepository('NFQAkademijaGalleryBundle:Album')
                ->findBy(array(), array('id' => 'DESC'));
        }

        return $this->albums;
    }

    /**
     * Deletes album by album id.
     * Throws exception if not found.
     *
     * @param $id
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAlbum($id)
    {
        $album = $this->entityManager->getRepository('NFQAkademijaGalleryBundle:Album')->find($id);

        if (!$album) {
            throw new NotFoundHttpException('No album found for id '.$id);
        }

        $this->entityManager->remove($album);
        $this->entityManager->flush();
    }

    /**
     * Gets album by album id and returns it.
     * If no album is found, creates new album object and returns it.
     *
     * @param $id
     * @return \NFQAkademija\GalleryBundle\Entity\Album
     */
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