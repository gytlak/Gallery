<?php

namespace NFQAkademija\GalleryBundle\Controller;

use NFQAkademija\GalleryBundle\Entity\Like;
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
    public function searchAction($name)
    {
        $em = $this->getDoctrine()->getManager();

        $tags = $em->getRepository('NFQAkademijaGalleryBundle:Tag')
                ->findBy(array('name' => $name), array('id' => 'DESC'));

        return $this->render(
            'NFQAkademijaGalleryBundle:Tag:search.html.twig',
            array(
                'tags' => $tags
            )
        );
    }

}