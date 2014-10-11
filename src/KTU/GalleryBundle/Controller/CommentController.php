<?php

namespace KTU\GalleryBundle\Controller;

use KTU\GalleryBundle\Entity\Comment;
use KTU\GalleryBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * Creates comment form and renders it.
     *
     * @param $id
     * @return Response
     */
    public function formAction($id)
    {
        $comment_form = $this->createForm(
            new CommentType(),
            new Comment(),
            array(
                'action' => $this->generateUrl('ktu_comment_post', array('id' => $id)),
            )
        );

        return $this->render(
            'KTUGalleryBundle:Comment:form.html.twig',
            array(
                'comment_form' => $comment_form->createView()
            )
        );
    }

    /**
     * Deletes comment by comment id.
     * Checks if user is admin.
     * Creates response.
     *
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('KTUGalleryBundle:Comment')->find($id);

        $admin = false;
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $admin = true;
        }
        if ($admin) {
            $em->remove($comment);
            $em->flush();
            return new Response(json_encode(array('status' => 'OK')));
        } else {
            return new Response(json_encode(array('status' => 'ERROR')));
        }
    }

    /**
     * Posts comment.
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function postAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $photo = $em->getRepository('KTUGalleryBundle:Photo')->find($id);

        if(!$photo) {
            return new Response('ERROR');
        }

        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new CommentType(), new Comment());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $comment = $form->getData();
            $comment->setUserId($user);
            $comment->setPhotoId($photo);
            $em->persist($comment);
            $em->flush();
        }

        return new Response('OK');
    }
}