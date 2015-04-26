<?php

namespace KTU\GalleryBundle\Controller;

use KTU\GalleryBundle\Entity\Tag;
use KTU\GalleryBundle\Form\TagType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    /**
     * Searches for photos by tag name
     * and renders photos by tag.
     *
     * @param $name
     * @return Response
     */
    public function resultsAction($name)
    {
        $em = $this->getDoctrine()->getManager();

        $tag = $em->getRepository('KTUGalleryBundle:Tag')->find($name);

        return $this->render(
            'KTUGalleryBundle:Tag:results.html.twig',
            [
                'tag' => $tag
            ]
        );
    }

    /**
     * Creates search form and renders it.
     *
     * @return Response
     */
    public function searchAction()
    {
        $form = $this->createForm(
            new TagType(true),
            new Tag(),
            [
                'action' => $this->generateUrl('ktu_search_post'),
            ]
        );

        return $this->render(
            'KTUGalleryBundle:Tag:search.html.twig',
            [
                'search_form' => $form->createView()
            ]
        );
    }

    /**
     * Handles search request from form and
     * redirects to index.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function postAction(Request $request)
    {
        $form = $this->createForm(new TagType(true), new Tag());
        $form->handleRequest($request);
        $tag = $form->getData();
        $name = $tag->getName();
        return $this->redirect($this->generateUrl('ktu_search_results', ['name' => $name]));
    }

}
