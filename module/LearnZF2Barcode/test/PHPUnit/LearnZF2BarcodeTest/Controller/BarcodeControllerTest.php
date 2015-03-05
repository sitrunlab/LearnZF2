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

namespace LearnZF2BarcodeTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class BarcodeControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))).'/config/application.config.php'
        );

        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/learn-zf2-barcode');
        $this->assertResponseStatusCode(200);
    }

    public function testPostData()
    {
        $postData = [
            'barcode-object-text' => '123456789',
            'barcode-object-select' => 'codabar',
        ];
        $this->dispatch('/learn-zf2-barcode', 'POST', $postData);

        $this->assertFileExists('./data/barcode.gif');
    }

    public function testAccessBarcodeImageWithoutAccessForm()
    {
        @unlink('./data/barcode.gif');

        $this->dispatch('/learn-zf2-barcode/getbarcodeimage');
        $this->assertResponseHeaderContains('Content-Type', 'text/html');
    }

    public function testAccessBarcodeImageWithccessFormBefore()
    {
        $postData = [
            'barcode-object-text' => '123456789',
            'barcode-object-select' => 'codabar',
        ];
        $this->dispatch('/learn-zf2-barcode', 'POST', $postData);

        $this->dispatch('/learn-zf2-barcode/getbarcodeimage');
        $this->assertResponseHeaderContains('Content-Type', 'image/gif');
    }
}
