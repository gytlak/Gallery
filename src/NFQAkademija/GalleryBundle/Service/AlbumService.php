<?php
namespace NFQAkademija\GalleryBundle\Service;


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

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
}