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

namespace LearnZF2LogTest\Form;

use LearnZF2Log\Form\LogForm;
use PHPUnit_Framework_TestCase;

class LogFormTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var LogForm
     */
    protected $logForm;

    public function setUp()
    {
        $this->logForm = new LogForm();
    }

    /**
     * @covers LearnZF2Log\Form\LogForm::init
     */
    public function testHasElement()
    {
        $this->logForm->init();
        $this->assertTrue($this->logForm->has('logmessage'));
        $this->assertTrue($this->logForm->has('logformat'));
        $this->assertTrue($this->logForm->has('logpriority'));
        $this->assertTrue($this->logForm->has('submit'));
    }

    /**
     * @covers LearnZF2Log\Form\LogForm::getInputFilterSpecification
     */
    public function testHasInputFilter()
    {
        $this->assertTrue($this->logForm->getInputFilter()->has('logmessage'));
    }
}
