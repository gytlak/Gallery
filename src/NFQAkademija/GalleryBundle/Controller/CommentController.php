<?php

namespace NFQAkademija\GalleryBundle\Controller;

use NFQAkademija\GalleryBundle\Entity\Comment;
use NFQAkademija\GalleryBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{

    public function formAction($id)
    {
        $comment_form = $this->createForm(
            new CommentType(),
            new Comment(),
            array(
                'action' => $this->generateUrl('nfqakademija_comment_post', array('id' => $id)),
            )
        );

        return $this->render(
            'NFQAkademijaGalleryBundle:Comment:form.html.twig',
            array(
                'comment_form' => $comment_form->createView()
            )
        );
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('NFQAkademijaGalleryBundle:Comment')->find($id);
        $err = true;

        try {
            $em->remove($comment);
            $em->flush();
        } catch (\Exception $e) {
            $err = false;
        }

        if ($err) {
            return new Response(json_encode(array('status' => 'OK')));
        } else {
            return new Response(json_encode(array('status' => 'ERROR')));
        }
    }

    public function postAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $photo = $em->getRepository('NFQAkademijaGalleryBundle:Photo')->find($id);

        if(!$photo) {
            return new Response('ERROR');
        }

        $form = $this->createForm(new CommentType(), new Comment());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $comment = $form->getData();
            $comment->setPhotoId($photo);
            $em->persist($comment);
            $em->flush();
        }

        return new Response('OK');
    }
}