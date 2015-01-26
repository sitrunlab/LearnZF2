<?php

namespace LearnZF2AjaxTest\Model;

use LearnZF2Ajax\Model\LoginInputFilter;
use PHPUnit_Framework_TestCase;
use Zend\InputFilter\InputFilter;

class LoginInputFilterTest extends PHPUnit_Framework_TestCase
{
    public function testHasFilters()
    {
        $loginInputFilter = new LoginInputFilter();
        $loginInputFilter->exchangeArray([
            'username' => 'admin',
            'password' => 'admin',
        ]);
        $this->assertSame(2, $loginInputFilter->getInputFilter()->count());
        $this->assertTrue($loginInputFilter->getInputFilter()->has('username'));
        $this->assertTrue($loginInputFilter->getInputFilter()->has('password'));
    }

    public function testExceptionCoughtWithSetInputFilter()
    {
        $this->setExpectedException('\Exception');
        $loginInputFilter = new LoginInputFilter();
        $loginInputFilter->setInputFilter(new InputFilter());
    }
}
