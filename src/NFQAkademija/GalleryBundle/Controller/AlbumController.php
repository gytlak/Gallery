<?php
namespace NFQAkademija\GalleryBundle\Controller;

use NFQAkademija\GalleryBundle\Entity\Album;
use NFQAkademija\GalleryBundle\Form\AlbumType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AlbumController extends Controller
{
    public function indexAction()
    {
        $albums = $this->getDoctrine()
            ->getRepository('NFQAkademijaGalleryBundle:Album')
            ->findBy(array(), array('id' => 'DESC'), 10);

        return $this->render(
            'NFQAkademijaGalleryBundle:Album:index.html.twig',
            array(
                'albums' => $albums
            )
        );
    }

    public function formAction()
    {
        $album_form = $this->createForm(
            new AlbumType(),
            new Album(),
            array(
                'action' => $this->generateUrl('nfqakademija_album_post'),
            )
        );

        return $this->render(
            'NFQAkademijaGalleryBundle:Album:form.html.twig',
            array(
                'album_form' => $album_form->createView()
            )
        );
    }

    public function postAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new AlbumType(), new Album());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $album = $form->getData();

            $album = $album->setUserId($user);
            $em->persist($album);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('nfqakademija_galleryadmin_homepage'));
    }
}