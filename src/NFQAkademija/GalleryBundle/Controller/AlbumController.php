<?php
namespace NFQAkademija\GalleryBundle\Controller;

use NFQAkademija\GalleryBundle\Entity\Album;
use NFQAkademija\GalleryBundle\Form\AlbumType;
use NFQAkademija\WallBundle\Service\AlbumService;
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

    public function formAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $album = $em->getRepository('NFQAkademijaGalleryBundle:Album')->find($id);

        if (!$album) {
            $album = new Album();
        }

        $form = $this->createForm(
            new AlbumType(),
            $album,
            array(
                'action' => $this->generateUrl('nfqakademija_album_post'),
            )
        );

        return $this->render(
            'NFQAkademijaGalleryBundle:Album:form.html.twig',
            array(
                'album_form' => $form->createView()
            )
        );
    }

    public function postAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new AlbumType(), new Album());

        $form->handleRequest($request);
        // REIKIA TAISYTI (REDAGUOJANT ALBUMĄ, SUKURIAMAS NAUJAS)
        if ($form->isValid()) {
            $album = $form->getData();
            $album = $album->setUserId($user);
            $em->persist($album);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('nfqakademija_galleryadmin_homepage'));
    }
}