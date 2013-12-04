<?php

namespace NFQAkademija\GalleryBundle\Controller;

use NFQAkademija\GalleryBundle\Entity\Like;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    /**
     * Checks if user already liked a photo,
     * if true responds that a like exists,
     * if false posts like.
     *
     * @param $id
     * @return Response
     */
    public function photoLikeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository('NFQAkademijaGalleryBundle:Like');
        $photo = $em->getRepository('NFQAkademijaGalleryBundle:Photo')->find($id);
        $userIp = $this->container->get('request')->getClientIp();
        $like = $obj->findBy(
            array(
                'userIp' => $userIp,
                'photoId' => $photo
            )
        );

        if($like) {
            //User already voted
            return new Response(json_encode(array('status' => 'EXISTS')));
        } else {
            $photoLike = new Like();
            $photoLike->setPhotoId($photo);
            $photoLike->setUserIp($userIp);
            $em->persist($photoLike);
            $em->flush();
            return new Response(json_encode(array('status' => 'OK')));
        }
    }

}