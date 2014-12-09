<?php

namespace ApplicationTest\Entity;

use Application\Entity\ModuleList;
use PHPUnit_Framework_TestCase;

class ModuleEntityTest extends PHPUnit_Framework_TestCase
{
    public function testSetGetModuleListEntity()
    {
        $entity = new ModuleList();
        $this->assertNull($entity->getId());
        $this->assertSame($entity, $entity->setModuleName('foo'));
        $this->assertSame('foo', $entity->getModuleName());
        $this->assertSame($entity, $entity->setModuleDesc('bar'));
        $this->assertSame('bar', $entity->getModuleDesc());
        $this->assertSame($entity, $entity->setModuleRoute('baz'));
        $this->assertSame('baz', $entity->getModuleRoute());
    }
}
