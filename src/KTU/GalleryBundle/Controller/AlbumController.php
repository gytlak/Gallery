<?php
namespace KTU\GalleryBundle\Controller;

use KTU\GalleryBundle\Entity\Album;
use KTU\GalleryBundle\Form\AlbumType;
use KTU\GalleryBundle\Service\AlbumService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AlbumController extends Controller
{
    /**
     * Gets albums from album service and renders them.
     *
     * @return Response
     */
    public function indexAction()
    {
        /** @var AlbumService $albumService */
        $albumService = $this->get('ktu_gallery.album_service');
        $albums = $albumService->getAlbums();

        return $this->render(
            'KTUGalleryBundle:Album:index.html.twig',
            array(
                'albums' => $albums
            )
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
            return new Response(json_encode(array('status' => 'OK')));
        } else {
            return new Response(json_encode(array('status' => 'ERROR')));
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
            array(
                'action' => $this->generateUrl('ktu_album_post', array('id' => $id)),
            )
        );

        return $this->render(
            'KTUGalleryBundle:Album:form.html.twig',
            array(
                'album_form' => $form->createView()
            )
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