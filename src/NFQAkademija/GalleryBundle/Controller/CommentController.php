<?php

namespace NFQAkademija\GalleryBundle\Controller;

use NFQAkademija\GalleryBundle\Entity\Comment;
use NFQAkademija\GalleryBundle\Form\CommentType;
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

    /**
     * Deletes comment by comment id.
     * Creates response.
     *
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('NFQAkademijaGalleryBundle:Comment')->find($id);

        $em->remove($comment);
        $em->flush();

        return new Response(json_encode(array('status' => 'OK')));
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
        $photo = $em->getRepository('NFQAkademijaGalleryBundle:Photo')->find($id);

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