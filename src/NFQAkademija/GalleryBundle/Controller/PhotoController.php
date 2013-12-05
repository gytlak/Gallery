<?php
namespace NFQAkademija\GalleryBundle\Controller;

use NFQAkademija\GalleryBundle\Entity\Photo;
use NFQAkademija\GalleryBundle\Form\PhotoType;
use NFQAkademija\GalleryBundle\Service\PhotoService;
use NFQAkademija\GalleryBundle\Service\AlbumService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhotoController extends Controller
{
    /**
     * Gets photos by album id using photo service
     * and album by album id using album service.
     * Renders them.
     *
     * @param $id
     * @return Response
     */
    public function indexAction($id)
    {
        /** @var PhotoService $photoService */
        $photoService = $this->get('nfqakademija_gallery.photo_service');
        $album = null;
        $photos = $photoService->getPhotos($id, $album);

        return $this->render(
            'NFQAkademijaGalleryBundle:Photo:index.html.twig',
            array(
                'photos' => $photos,
                'album' => $album
            )
        );
    }

    /**
     * Deletes photo by photo id using photo service.
     * Creates response.
     *
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {
        /** @var PhotoService $photoService */
        $photoService = $this->get('nfqakademija_gallery.photo_service');
        $user = $this->get('security.context')->getToken()->getUser();
        $admin = false;
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $admin = true;
        }

        if ($photoService->deletePhoto($id, $user, $admin)) {
            return new Response(json_encode(array('status' => 'OK')));
        } else {
            return new Response(json_encode(array('status' => 'ERROR')));
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
        $photoService = $this->get('nfqakademija_gallery.photo_service');
        $photo = $photoService->getPhoto($id);

        return $this->render(
            'NFQAkademijaGalleryBundle:Photo:photo.html.twig',
            array(
                'photo' => $photo
            )
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
        $photoService = $this->get('nfqakademija_gallery.photo_service');
        /** @var AlbumService $albumService */
        $albumService = $this->get('nfqakademija_gallery.album_service');

        $user = $this->get('security.context')->getToken()->getUser();

        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $admin = true;
            $albums = $albumService->getAlbums();
        } else {
            $admin = false;
            $albums = $albumService->getAlbumsByUser($user);
        }

        $photo = $photoService->setPhoto($id, $user, $admin);


        $form = $this->createForm(
            new PhotoType($photo, $albums),
            $photo,
            array(
                'action' => $this->generateUrl('nfqakademija_photo_post', array('id' => $id)),
            )
        );

        return $this->render(
            'NFQAkademijaGalleryBundle:Photo:form.html.twig',
            array(
                'photo_form' => $form->createView()
            )
        );
    }

    /**
     * Posts photo and redirects to homepage.
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function postAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $photo = $em->getRepository('NFQAkademijaGalleryBundle:Photo')->find($id);

        if (!$photo) {
            $photo = new Photo();
        }

        /** @var AlbumService $albumService */
        $albumService = $this->get('nfqakademija_gallery.album_service');

        $user = $this->get('security.context')->getToken()->getUser();

        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $albums = $albumService->getAlbums();
        } else {
            $albums = $albumService->getAlbumsByUser($user);
        }

        $form = $this->createForm(new PhotoType($photo, $albums), $photo);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $photo = $form->getData();
            $photo->setUserId($user);
            $em->persist($photo);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('nfqakademija_gallery_homepage'));
    }
}