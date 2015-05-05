<?php

namespace KTU\GalleryBundle\Tests\Service;

use Doctrine\Common\Persistence\ObjectManager;
use KTU\GalleryBundle\Entity\Album;
use KTU\GalleryBundle\Entity\Photo;
use KTU\GalleryBundle\Entity\Tag;
use KTU\GalleryBundle\Entity\User;
use KTU\GalleryBundle\Service\PhotoService;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

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

        $entityManager->expects($this->any())
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

        // case #1
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
        $photoService = new PhotoService($this->getEntityManagerMock($fixture));

        $album = null;
        if ($expected !== 'exception') {
            $this->assertEquals($expected, $photoService->getPhotos(1, $album));
        } else {
            $this->setExpectedException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
            $photoService->getPhotos(1, $album);
        }
    }

    public function getPhotoProvider()
    {
        $out = [];

        // case #0
        $out[] = [
            new Photo(),
            new Photo()
        ];

        // case #1
        $out[] = [
            null,
            'exception'
        ];

        return $out;
    }

    /**
     * @dataProvider getPhotoProvider
     */
    public function testGetPhoto($fixture, $expected)
    {
        $photoService = new PhotoService($this->getEntityManagerMock($fixture));

        if ($expected !== 'exception') {
            $this->assertEquals($expected, $photoService->getPhoto(1));
        } else {
            $this->setExpectedException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
            $photoService->getPhoto(1);
        }
    }

    public function deletePhotoProvider()
    {
        $out = [];

        // case #0 photo wasn't found so delete returns false
        $out[] = [
            null,
            false,
            false
        ];

        // case #1 photo deleted successfully because user is administrator
        $out[] = [
            new Photo(),
            true,
            true
        ];

        // case #2 photo deleted successfully because user is photo's creator
        $photo = new Photo();
        $user = new User();
        $photo->setUserId($user);

        $out[] = [
            $photo,
            false,
            true,
            $user
        ];

        return $out;
    }

    /**
     * @dataProvider deletePhotoProvider
     */
    public function testDeletePhoto($fixture, $isAdmin, $expected, $user = null)
    {
        $photoService = new PhotoService($this->getEntityManagerMock($fixture));

        $this->assertEquals($expected, $photoService->deletePhoto(1, $user, $isAdmin));
    }

    public function getUserPhotoProvider()
    {
        $out = [];

        // case #0 photo wasn't found so returns null
        $out[] = [
            null,
            false,
            null
        ];

        // case #1 photo returned because user is administrator
        $out[] = [
            new Photo(),
            true,
            new Photo()
        ];

        // case #2 photo returned because user is photo's creator
        $photo = new Photo();
        $user = new User();
        $photo->setUserId($user);

        $out[] = [
            $photo,
            false,
            $photo,
            $user
        ];

        return $out;
    }

    /**
     * @dataProvider getUserPhotoProvider
     */
    public function testGetUserPhoto($fixture, $isAdmin, $expected, $user = null)
    {
        $photoService = new PhotoService($this->getEntityManagerMock($fixture));

        $id = 1;
        $this->assertEquals($expected, $photoService->getUserPhoto($id, $user, $isAdmin));
    }

    public function savePhotoProvider()
    {
        $out = [];

        // case #0
        $out[] = [
            null,
            [
                'name' => 'name',
                'shortDescription' => 'desc',
                'albums' => [
                    new Album()
                ],
                'photos' => [
                    new Photo()
                ],
                'tags' => [
                    new Tag()
                ]
            ],
            new User()
        ];

        // case #1
        $out[] = [
            new Tag(),
            [
                'name' => 'name',
                'shortDescription' => 'desc',
                'albums' => [
                    new Album()
                ],
                'photos' => [
                    new Photo(),
                    new Photo()
                ],
                'tags' => [
                    new Tag()
                ]
            ],
            new User()
        ];

        return $out;
    }

    /**
     * @dataProvider savePhotoProvider
     */
    public function testSavePhoto($entityManagerReturn, $formReturn, $user)
    {
        $photoService = new PhotoService($this->getEntityManagerMock($entityManagerReturn));

        $photoService->savePhoto($this->getFormMock($formReturn), $this->getRequestMock(), $user);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Request
     */
    public function getRequestMock()
    {
        $request = $this
            ->getMockBuilder('\Symfony\Component\HttpFoundation\Request')
            ->disableOriginalConstructor()
            ->getMock();

        return $request;
    }

    /**
     * @param $return
     * @return \PHPUnit_Framework_MockObject_MockObject|Form
     */
    public function getFormMock($return)
    {
        $request = $this
            ->getMockBuilder('\Symfony\Component\Form\Form')
            ->disableOriginalConstructor()
            ->getMock();

        $request->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));

        $request->expects($this->any())
            ->method('getData')
            ->will($this->returnValue($return));

        return $request;
    }
}
