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
     * Gets all albums.
     *
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
     * Gets albums by user.
     *
     * @return array|null
     */
    public function getAlbumsByUser($user)
    {
        if(!$this->albums) {
            $this->albums = $this->entityManager->getRepository('NFQAkademijaGalleryBundle:Album')
                ->findBy(array('userId' => $user), array('id' => 'DESC'));
        }

        return $this->albums;
    }

    /**
     * Deletes album by album id.
     * Checks if user has right to delete it.
     *
     * @param $id
     * @param $user
     * @param $admin
     * @return bool
     */
    public function deleteAlbum($id, $user, $admin)
    {
        $album = $this->entityManager->getRepository('NFQAkademijaGalleryBundle:Album')->find($id);

        if (!$album) {
            return false;
        } else if ($album->getUserId() == $user || $admin) {
            $this->entityManager->remove($album);
            $this->entityManager->flush();
            return true;
        }

        return false;
    }

    /**
     * Gets album by album id and returns it.
     * If no album is found or user ir not author of the album
     * or not admin, returns new album object.
     *
     * @param $id
     * @param $user
     * @param $admin
     * @return \NFQAkademija\GalleryBundle\Entity\Album
     */
    public function getAlbum(&$id, $user, $admin)
    {
        $album = $this->entityManager->getRepository('NFQAkademijaGalleryBundle:Album')->find($id);

        if ($album && ($album->getUserId() == $user || $admin)) {
            return $album;
        }

        $album = new Album();
        $id = 0;

        return $album;
    }
}