<?php

namespace KTU\GalleryBundle\Tests\Service;

use Doctrine\Common\Persistence\ObjectManager;
use KTU\GalleryBundle\Entity\Album;
use KTU\GalleryBundle\Entity\User;
use KTU\GalleryBundle\Service\AlbumService;

class AlbumServiceTest extends \PHPUnit_Framework_TestCase
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

    public function getAlbumsProvider()
    {
        $out = [];

        // case #0
        $out[] = [
            ['albums'],
            ['albums']
        ];

        return $out;
    }

    /**
     * @dataProvider getAlbumsProvider
     */
    public function testGetAlbums($fixture, $expected)
    {
        $albumService = new AlbumService($this->getEntityManagerMock($fixture));

        $this->assertEquals($expected, $albumService->getAlbums());
    }

    /**
     * @dataProvider getAlbumsProvider
     */
    public function testGetAlbumsByUser($fixture, $expected)
    {
        $albumService = new AlbumService($this->getEntityManagerMock($fixture));

        $this->assertEquals($expected, $albumService->getAlbumsByUser('irrelevant'));
    }

    public function deleteAlbumProvider()
    {
        $out = [];

        // case #0 album wasn't found so delete returns false
        $out[] = [
            null,
            false,
            false
        ];

        // case #1 album deleted successfully because user is administrator
        $album = new Album();
        $user = new User();
        $album->setUserId($user);

        $out[] = [
            $album,
            true,
            true
        ];

        // case #2 album deleted successfully because user is album's creator
        $album = new Album();
        $user = new User();
        $album->setUserId($user);

        $out[] = [
            $album,
            false,
            true,
            $user
        ];

        return $out;
    }

    /**
     * @dataProvider deleteAlbumProvider
     */
    public function testDeleteAlbum($fixture, $isAdmin, $expected, $user = null)
    {
        $albumService = new AlbumService($this->getEntityManagerMock($fixture));

        $this->assertEquals($expected, $albumService->deleteAlbum(1, $user, $isAdmin));
    }

    public function getAlbumProvider()
    {
        $out = [];

        // case #0 album wasn't found so new album is returned
        $out[] = [
            null,
            false,
            new Album()
        ];

        // case #1 album is found and returned because user is administrator
        $album = new Album();
        $user = new User();
        $album->setUserId($user);

        $out[] = [
            $album,
            true,
            $album
        ];

        // case #2 album is found and returned because user is album's creator
        $album = new Album();
        $user = new User();
        $album->setUserId($user);

        $out[] = [
            $album,
            false,
            $album,
            $user
        ];

        return $out;
    }

    /**
     * @dataProvider getAlbumProvider
     */
    public function testGetAlbum($fixture, $isAdmin, $expected, $user = null)
    {
        $albumService = new AlbumService($this->getEntityManagerMock($fixture));

        $id = 1;
        $this->assertEquals($expected, $albumService->getAlbum($id, $user, $isAdmin));
    }
}
