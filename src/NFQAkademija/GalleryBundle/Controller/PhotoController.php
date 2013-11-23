<?php
namespace NFQAkademija\GalleryBundle\Controller;

use NFQAkademija\GalleryBundle\Entity\Photo;
use NFQAkademija\GalleryBundle\Form\PhotoType;
use NFQAkademija\GalleryBundle\Service\PhotoService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhotoController extends Controller
{

    public function indexAction($id)
    {
        /** @var PhotoService $photoService */
        $photoService = $this->get('nfqakademija_gallery.photo_service');
        $photos = $photoService->getPhotos($id);

        return $this->render(
            'NFQAkademijaGalleryBundle:Photo:index.html.twig',
            array(
                'photos' => $photos
            )
        );
    }

    public function deleteAction($id)
    {
        /** @var PhotoService $photoService */
        $photoService = $this->get('nfqakademija_gallery.photo_service');
        $photoService->deletePhoto($id);

        return new Response(json_encode(array('status' => 'OK')));
    }

    public function formAction($id)
    {
        /** @var PhotoService $photoService */
        $photoService = $this->get('nfqakademija_gallery.photo_service');
        $photo = $photoService->setPhoto($id);

        $form = $this->createForm(
            new PhotoType(),
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

    public function postAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $photo = $em->getRepository('NFQAkademijaGalleryBundle:Photo')->find($id);

        if (!$photo) {
            $photo = new Photo();
        }

        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new PhotoType(), $photo);

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