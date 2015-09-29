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

namespace LearnZF2LogTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))).'/config/application.config.php'
        );

        parent::setUp();
    }

    /**
     * @return array
     */
    public function provideValidDataPriority()
    {
        return [
            [0, 'EMERG'],
            [1, 'ALERT'],
            [2, 'CRIT'],
            [3, 'ERR'],
            [4, 'WARN'],
            [5, 'NOTICE'],
            [6, 'INFO'],
            [7, 'DEBUG'],
        ];
    }

    /**
     * @dataProvider provideValidDataPriority
     */
    public function testPostData($priority, $priorityDesc)
    {
        $postData = [
            'logmessage' => 'a log message',
            'logformat' => 'xml',
            'logpriority' => $priority,
        ];
        $this->dispatch('/learn-zf2-log', 'POST', $postData);
        $response = $this->getResponse();

        $this->assertContains('priority&gt;'.$priority.'&lt;/priority&gt;&lt;priorityName&gt;'.$priorityDesc.'&lt;/priorityName&gt;&lt;message&gt;'.$postData['logmessage'].'&lt;/message&gt;&lt;/log', $response->getBody());
    }

    public function testInvalidPostData()
    {
        $postData = [
            'logmessage' => 'foo',
            'logformat' => 'notvalidformat',
            'logpriority' => 100,
        ];
        $this->dispatch('/learn-zf2-log', 'POST', $postData);
        $response = $this->getResponse();

        $this->assertContains('EMERG (0): this is log message', $response->getBody());
    }
}
