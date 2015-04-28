<?php
namespace KTU\GalleryBundle\Controller;

use KTU\GalleryBundle\Entity\Album;
use KTU\GalleryBundle\Form\AlbumType;
use KTU\GalleryBundle\Service\AlbumService;
use KTU\GalleryBundle\Service\PhotoService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AlbumController extends Controller
{
    /**
     * Gets photos and album by album id using photo service.
     * Renders them.
     *
     * @param $id
     * @return Response
     */
    public function albumAction($id)
    {
        /** @var PhotoService $photoService */
        $photoService = $this->get('ktu_gallery.photo_service');
        $album = null;
        $photos = $photoService->getPhotos($id, $album);

        return $this->render(
            'KTUGalleryBundle:Album:album.html.twig',
            [
                'photos' => $photos,
                'album' => $album
            ]
        );
    }

    /**
     * Gets albums from album service and renders them.
     *
     * @return Response
     */
    public function albumsAction()
    {
        /** @var AlbumService $albumService */
        $albumService = $this->get('ktu_gallery.album_service');
        $albums = $albumService->getAlbums();

        return $this->render(
            'KTUGalleryBundle:Album:albums.html.twig',
            [
                'albums' => $albums
            ]
        );
    }

    /**
     * Gets user albums from album service and renders them.
     *
     * @return Response
     */
    public function userAlbumsAction()
    {
        /** @var AlbumService $albumService */
        $albumService = $this->get('ktu_gallery.album_service');
        $albums = $albumService->getAlbumsByUser($this->get('security.context')->getToken()->getUser());

        return $this->render(
            'KTUGalleryBundle:Album:albums.html.twig',
            [
                'albums' => $albums
            ]
        );
    }

    /**
     * Deletes album by album id using album service.
     * Creates a response.
     *
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {
        /** @var AlbumService $albumService */
        $albumService = $this->get('ktu_gallery.album_service');
        $admin = false;
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $admin = true;
        }
        $user = $this->get('security.context')->getToken()->getUser();

        if ($albumService->deleteAlbum($id, $user, $admin)) {
            return new Response(json_encode(['status' => 'OK']));
        } else {
            return new Response(json_encode(['status' => 'ERROR']));
        }
    }

    /**
     * Creates album form and renders it.
     *
     * @param $id
     * @return Response
     */
    public function formAction($id)
    {
        /** @var AlbumService $albumService */
        $albumService = $this->get('ktu_gallery.album_service');
        $user = $this->get('security.context')->getToken()->getUser();
        $admin = false;
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $admin = true;
        }
        $album = $albumService->getAlbum($id, $user, $admin);

        $form = $this->createForm(
            new AlbumType($album),
            $album,
            [
                'action' => $this->generateUrl('ktu_album_post', ['id' => $id]),
            ]
        );

        return $this->render(
            'KTUGalleryBundle:Album:form.html.twig',
            [
                'album_form' => $form->createView()
            ]
        );
    }

    /**
     * Posts album and redirects to homepage.
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function postAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $album = $em->getRepository('KTUGalleryBundle:Album')->find($id);

        if (!$album) {
            $album = new Album();
        }

        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new AlbumType($album), $album);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $album = $form->getData();
            $album->setUserId($user);
            $em->persist($album);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('ktu_gallery_homepage'));
    }
}
