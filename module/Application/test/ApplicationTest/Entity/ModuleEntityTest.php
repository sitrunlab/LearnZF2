<?php

namespace ApplicationTest\Entity;

use Application\Entity\ModuleList;
use PHPUnit_Framework_TestCase;

class ModuleEntityTest extends PHPUnit_Framework_TestCase
{
    public function testPersistModuleListAndGetIt()
    {
        $entity = new ModuleList();
        $entity->setModuleName('foo');
        $entity->setModuleDesc('bar');
        $entity->setModuleRoute('baz');

        $entityMock = $this->getMock('Application\Entity\ModuleList');
        $entityMock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue($entity->getId()));
        $entityMock->expects($this->once())
            ->method('getModuleName')
            ->will($this->returnValue($entity->getModuleName()));
        $entityMock->expects($this->once())
            ->method('getModuleDesc')
            ->will($this->returnValue($entity->getModuleDesc()));
        $entityMock->expects($this->once())
            ->method('getModuleRoute')
            ->will($this->returnValue($entity->getModuleRoute()));

        $entityManagerMock = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManagerMock->expects($this->once())
            ->method('persist')
            ->will($this->returnValue($entity));
        $entityManagerMock->expects($this->once())
            ->method('flush');

        $entityManagerMock->persist($entity);
        $entityManagerMock->flush();

        $this->assertEquals($entity->getId(), $entityMock->getId());
        $this->assertEquals($entity->getModuleName(), $entityMock->getModuleName());
        $this->assertEquals($entity->getModuleDesc(), $entityMock->getModuleDesc());
        $this->assertEquals($entity->getModuleRoute(), $entityMock->getModuleRoute());
    }
}
