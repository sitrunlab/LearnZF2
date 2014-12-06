<?php

namespace ApplicationTest\Entity;

use PHPUnit_Framework_TestCase;

class ModuleEntityTest extends PHPUnit_Framework_TestCase
{
    public function testFindGetOneData()
    {
        $entity = $this->getMock('Application\Entity\ModuleList');
        $entity->expects($this->once())
            ->method('getId')
            ->will($this->returnValue(1));
        $entity->expects($this->once())
            ->method('setModuleName')
            ->with('LearnZF2FormUsage')
            ->will($this->returnValue($entity));
        $entity->expects($this->once())
            ->method('getModuleName')
            ->will($this->returnValue('LearnZF2FormUsage'));
        $entity->expects($this->once())
            ->method('setModuleDesc')
            ->with('Learn Form Usage with ZF2')
            ->will($this->returnValue($entity));
        $entity->expects($this->once())
            ->method('getModuleDesc')
            ->will($this->returnValue('Learn Form Usage with ZF2'));
        $entity->expects($this->once())
            ->method('setModuleRoute')
            ->with('learn-zf2-form-usage')
            ->will($this->returnValue($entity));
        $entity->expects($this->once())
            ->method('getModuleRoute')
            ->will($this->returnValue('learn-zf2-form-usage'));

        $entityRepository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $entityRepository->expects($this->once())
            ->method('find')
            ->will($this->returnValue($entity));

        $entityManager = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($entityRepository));

        $findId1 = $entityManager->getRepository('Application\Entity\ModuleList')->find(1);
        $this->assertEquals(1, $findId1->getId());
        $this->assertInstanceOf('Application\Entity\ModuleList', $findId1->setModuleName('LearnZF2FormUsage'));
        $this->assertEquals('LearnZF2FormUsage', $findId1->getModuleName());
        $this->assertInstanceOf('Application\Entity\ModuleList', $findId1->setModuleDesc('Learn Form Usage with ZF2'));
        $this->assertEquals('Learn Form Usage with ZF2', $findId1->getModuleDesc());
        $this->assertInstanceOf('Application\Entity\ModuleList', $findId1->setModuleRoute('learn-zf2-form-usage'));
        $this->assertEquals('learn-zf2-form-usage', $findId1->getModuleRoute());
    }
}
