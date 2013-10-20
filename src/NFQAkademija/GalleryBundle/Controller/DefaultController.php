<?php

namespace NFQAkademija\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NFQAkademijaGalleryBundle:Default:index.html.twig', array());
    }
}
