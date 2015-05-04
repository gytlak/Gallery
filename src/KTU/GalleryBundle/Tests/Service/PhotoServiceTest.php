<?php

namespace KTU\GalleryBundle\Tests\Service;

use Doctrine\Common\Persistence\ObjectManager;
use KTU\GalleryBundle\Entity\Album;
use KTU\GalleryBundle\Entity\Photo;
use KTU\GalleryBundle\Entity\User;
use KTU\GalleryBundle\Service\AlbumService;
use KTU\GalleryBundle\Service\PhotoService;

class PhotoServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $return
     * @return \PHPUnit_Framework_MockObject_MockObject|ObjectManager
     */
    public function getEntityManagerMock($return)
    {
        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $objectRepository = $this
            ->getMockBuilder('\Doctrine\Common\Persistence\ObjectRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $objectRepository->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue($return));

        $objectRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($return));

        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($objectRepository));

        return $entityManager;
    }

    public function getPhotosProvider()
    {
        $out = [];

        $album = new Album();
        $photo = new Photo();
        $album->addPhoto($photo);

        // case #0
        $out[] = [
            $album,
            $album->getPhotos()
        ];

        // case #0
        $out[] = [
            null,
            'exception'
        ];

        return $out;
    }

    /**
     * @dataProvider getPhotosProvider
     */
    public function testGetPhotos($fixture, $expected)
    {
        $albumService = new PhotoService($this->getEntityManagerMock($fixture));

        $album = null;
        if ($expected !== 'exception') {
            $this->assertEquals($expected, $albumService->getPhotos(1, $album));
        } else {
            $this->setExpectedException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
            $albumService->getPhotos(1, $album);
        }
    }
}
