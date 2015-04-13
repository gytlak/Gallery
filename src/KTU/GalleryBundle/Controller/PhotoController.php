<?php
namespace KTU\GalleryBundle\Controller;

use KTU\GalleryBundle\Entity\Photo;
use KTU\GalleryBundle\Entity\Tag;
use KTU\GalleryBundle\Form\PhotoType;
use KTU\GalleryBundle\Service\PhotoService;
use KTU\GalleryBundle\Service\AlbumService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhotoController extends Controller
{
    /**
     * Gets photos and album by album id using photo service.
     * Renders them.
     *
     * @param $id
     * @return Response
     */
    public function indexAction($id)
    {
        /** @var PhotoService $photoService */
        $photoService = $this->get('ktu_gallery.photo_service');
        $album = null;
        $photos = $photoService->getPhotos($id, $album);

        return $this->render(
            'KTUGalleryBundle:Photo:index.html.twig',
            array(
                'photos' => $photos,
                'album' => $album
            )
        );
    }

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
        $photoService = $this->get('ktu_gallery.photo_service');
        $photo = $photoService->getPhoto($id);

        return $this->render(
            'KTUGalleryBundle:Photo:photo.html.twig',
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

        $photo = $photoService->setPhoto($id, $user, $admin);


        $form = $this->createForm(
            new PhotoType($photo, $albums),
            null,
            array(
                'action' => $this->generateUrl('ktu_photo_post', array('id' => $id)),
            )
        );

        return $this->render(
            'KTUGalleryBundle:Photo:form.html.twig',
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

        $photo = $em->getRepository('KTUGalleryBundle:Photo')->find($id);

        if (!$photo) {
            $photo = new Photo();
        }

        /** @var AlbumService $albumService */
        $albumService = $this->get('ktu_gallery.album_service');

        $user = $this->get('security.context')->getToken()->getUser();

        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $albums = $albumService->getAlbums();
        } else {
            $albums = $albumService->getAlbumsByUser($user);
        }

        $form = $this->createForm(new PhotoType($photo, $albums), null);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $i=1;
            foreach ($form->getData()['photos'] as $item) {
                $document = new Photo();
                $document->setName($form->getData()['name'] . ' ' . $i);
                $document->setPhoto($item);
                $document->setUserId($user);
                $document->setShortDescription($form->getData()['shortDescription']);
                $document->setAlbums($form->getData()['albums']);
                foreach (explode(',', $form->getData()['tags']) as $tag) {
                    $documentTag = new Tag();
                    $documentTag->setPhoto($document);
                    $documentTag->setName($tag);
                    $document->addTag($documentTag);
                }
                $em->persist($document);
                $i++;
            }
            $em->flush();
        }
        return $this->redirect($this->generateUrl('ktu_gallery_homepage'));
    }
}
