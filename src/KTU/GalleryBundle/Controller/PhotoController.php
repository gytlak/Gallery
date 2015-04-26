<?php
namespace KTU\GalleryBundle\Controller;

use KTU\GalleryBundle\Entity\Photo;
use KTU\GalleryBundle\Entity\Tag;
use KTU\GalleryBundle\Form\PhotoEditType;
use KTU\GalleryBundle\Form\PhotoType;
use KTU\GalleryBundle\Service\PhotoService;
use KTU\GalleryBundle\Service\AlbumService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhotoController extends Controller
{
    /**
     * Deletes photo by photo id using photo service.
     * Checks if user is admin.
     * Creates response.
     *
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {
        /** @var PhotoService $photoService */
        $photoService = $this->get('ktu_gallery.photo_service');
        $user = $this->get('security.context')->getToken()->getUser();
        $admin = false;
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $admin = true;
        }

        if ($photoService->deletePhoto($id, $user, $admin)) {
            return new Response(json_encode(['status' => 'OK']));
        } else {
            return new Response(json_encode(['status' => 'ERROR']));
        }
    }

    /**
     * Gets photo by photo id using photo service.
     * Renders it.
     *
     * @param $id
     * @return Response
     */
    public function showPhotoAction($id)
    {
        /** @var PhotoService $photoService */
        $photoService = $this->get('ktu_gallery.photo_service');
        $photo = $photoService->getPhoto($id);

        return $this->render(
            'KTUGalleryBundle:Photo:photo.html.twig',
            [
                'photo' => $photo
            ]
        );
    }

    /**
     * Creates photo form and renders it.
     * Also checks if user is admin and gives to form
     * either a an array of user albums or all albums
     *
     * @param $id
     * @return Response
     */
    public function formAction($id)
    {
        /** @var PhotoService $photoService */
        $photoService = $this->get('ktu_gallery.photo_service');
        /** @var AlbumService $albumService */
        $albumService = $this->get('ktu_gallery.album_service');

        $user = $this->get('security.context')->getToken()->getUser();

        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $admin = true;
            $albums = $albumService->getAlbums();
        } else {
            $admin = false;
            $albums = $albumService->getAlbumsByUser($user);
        }

        $photo = $photoService->getUserPhoto($id, $user, $admin);

        if ($photo) {
            $form = $this->createForm(
                new PhotoEditType($photo, $albums),
                $photo,
                [
                    'action' => $this->generateUrl('ktu_photo_edit', ['id' => $id]),
                ]
            );
        } else {
            $form = $this->createForm(
                new PhotoType($albums),
                null,
                [
                    'action' => $this->generateUrl('ktu_photo_post', ['id' => $id]),
                ]
            );
        }

        return $this->render(
            'KTUGalleryBundle:Photo:form.html.twig',
            [
                'photo_form' => $form->createView()
            ]
        );
    }

    /**
     * Posts photo and redirects to homepage.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function postAction(Request $request)
    {
        /** @var AlbumService $albumService */
        $albumService = $this->get('ktu_gallery.album_service');
        /** @var PhotoService $photoService */
        $photoService = $this->get('ktu_gallery.photo_service');

        $user = $this->get('security.context')->getToken()->getUser();
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $albums = $albumService->getAlbums();
        } else {
            $albums = $albumService->getAlbumsByUser($user);
        }

        $form = $this->createForm(new PhotoType($albums), null);

        $photoService->savePhoto($form, $request, $user);

        return $this->redirect($this->generateUrl('ktu_gallery_homepage'));
    }

    /**
     * Posts photo and redirects to homepage.
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Photo $photo */
        $photo = $em->getRepository('KTUGalleryBundle:Photo')->find($id);

        /** @var AlbumService $albumService */
        $albumService = $this->get('ktu_gallery.album_service');

        $user = $this->get('security.context')->getToken()->getUser();
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $albums = $albumService->getAlbums();
        } else {
            $albums = $albumService->getAlbumsByUser($user);
        }

        $form = $this->createForm(new PhotoEditType($photo, $albums));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $photo->setName($form->getData()->getName());
            $photo->setShortDescription($form->getData()->getShortDescription());
            $photo->setAlbums($form->getData()->getAlbums());
            /** @var Tag $tag */
            foreach ($form->getData()->getTags() as $tag) {
                $existingTag = $em->getRepository('KTUGalleryBundle:Tag')->find($tag->getName());

                if ($existingTag) {
                    if (!$photo->getTags()->contains($existingTag)) {
                        $photo->addTag($existingTag);
                    }
                } else {
                    $photo->addTag($tag);
                }
            }
            $em->persist($photo);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('ktu_gallery_homepage'));
    }
}
