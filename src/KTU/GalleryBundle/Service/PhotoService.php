<?php
namespace KTU\GalleryBundle\Service;

use Doctrine\ORM\EntityManager;
use KTU\GalleryBundle\Entity\Photo;
use KTU\GalleryBundle\Entity\Tag;
use KTU\GalleryBundle\Entity\User;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PhotoService
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var null
     */
    protected $photos = null;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
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

    /**
     * @param Form    $form
     * @param Request $request
     * @param User    $user
     */
    public function savePhoto(Form $form, Request $request, User $user)
    {
        $form->handleRequest($request);

        if ($form->isValid()) {
            $i = 1;
            foreach ($form->getData()['photos'] as $item) {
                $document = new Photo();
                if (count($form->getData()['photos']) > 1) {
                    $document->setName($form->getData()['name'] . ' ' . $i);
                } else {
                    $document->setName($form->getData()['name']);
                }
                $document->setPhoto($item);
                $document->setUserId($user);
                $document->setShortDescription($form->getData()['shortDescription']);
                $document->setAlbums($form->getData()['albums']);
                /** @var Tag $tag */
                foreach ($form->getData()['tags'] as $tag) {
                    $existingTag = $this->entityManager->getRepository('KTUGalleryBundle:Tag')->find($tag->getName());

                    if ($existingTag) {
                        $document->addTag($existingTag);
                    } else {
                        $document->addTag($tag);
                    }
                }
                $this->entityManager->persist($document);
                $i++;
            }
            $this->entityManager->flush();
        }
    }
}
