<?php

/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

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
