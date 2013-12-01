<?php
namespace NFQAkademija\GalleryBundle\Controller;

use NFQAkademija\GalleryBundle\Entity\Album;
use NFQAkademija\GalleryBundle\Form\AlbumType;
use NFQAkademija\GalleryBundle\Service\AlbumService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AlbumController extends Controller
{

    public function indexAction()
    {
        /** @var AlbumService $albumService */
        $albumService = $this->get('nfqakademija_gallery.album_service');
        $albums = $albumService->getAlbums();

        return $this->render(
            'NFQAkademijaGalleryBundle:Album:index.html.twig',
            array(
                'albums' => $albums
            )
        );
    }

    public function deleteAction($id)
    {
        /** @var AlbumService $albumService */
        $albumService = $this->get('nfqakademija_gallery.album_service');
        $albumService->deleteAlbum($id);

        return new Response(json_encode(array('status' => 'OK')));
    }

    public function formAction($id)
    {
        /** @var AlbumService $albumService */
        $albumService = $this->get('nfqakademija_gallery.album_service');
        $album = $albumService->getAlbum($id);

        $form = $this->createForm(
            new AlbumType($album),
            $album,
            array(
                'action' => $this->generateUrl('nfqakademija_album_post', array('id' => $id)),
            )
        );

        return $this->render(
            'NFQAkademijaGalleryBundle:Album:form.html.twig',
            array(
                'album_form' => $form->createView()
            )
        );
    }

    public function postAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $album = $em->getRepository('NFQAkademijaGalleryBundle:Album')->find($id);

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
        return $this->redirect($this->generateUrl('nfqakademija_gallery_homepage'));
    }
}