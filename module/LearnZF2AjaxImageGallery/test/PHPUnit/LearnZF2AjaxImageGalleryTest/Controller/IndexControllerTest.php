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

namespace LearnZF2AjaxImageGalleryTest\Controller;

use Zend\File\Transfer\Adapter\Http;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Validator\File\Extension;
use Zend\Validator\File\IsImage;
use Zend\Validator\File\Size;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    /**
     * Creates instanse of Http adapter used to validated files.
     *
     * @var Http
     */
    private $adapter;

    public function setUp()
    {
        $this->setApplicationConfig(
            include dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))).'/config/application.config.php'
        );

        /*
         * This will always throw "file was illegally uploaded. This could be a possible attack"
         */
        $_FILES = array(
            'imageUpload' => array(
                'name' => __DIR__.DIRECTORY_SEPARATOR.'_files'.DIRECTORY_SEPARATOR.'test1.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => __DIR__.DIRECTORY_SEPARATOR.'_files'.DIRECTORY_SEPARATOR.'test1.jpg',
                'error' => 0,
                'size' => 746663,
            ),
        );

        $this->adapter = new Http();

        parent::setUp();
    }

    /**
     * Called after every test.
     *
     * @method tearDown
     *
     * @return void
     */
    public function tearDown()
    {
    }

    public function testIndexAction()
    {
        $this->dispatch('/learn-zf2-ajax-image-gallery');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('LearnZF2AjaxImageGallery');
        $this->assertControllerName('LearnZF2AjaxImageGallery\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('learn-zf2-ajax-image-gallery');
    }

    public function testIndexActionHasForm()
    {
        $this->dispatch('/learn-zf2-ajax-image-gallery');
        $this->assertQuery('body form#upload');
    }

    public function testAdapterHasValidators()
    {
        $size = new Size(array('min' => '10kB', 'max' => '5MB','useByteString' => true));
        $extension = new Extension(array('jpg','gif','png','jpeg','bmp','webp','svg'), true);

        $this->adapter->setValidators(array($size, new IsImage(), $extension));

        $testExtension = $this->adapter->getValidator('Extension');
        $testIsImage = $this->adapter->getValidator('IsImage');
        $testSize = $this->adapter->getValidator('Size');

        $this->assertInstanceOf('Zend\Validator\File\Extension', $testExtension);
        $this->assertInstanceOf('Zend\Validator\File\IsImage', $testIsImage);
        $this->assertInstanceOf('Zend\Validator\File\Size', $testSize);
    }

    public function testFileIsUploaded()
    {
        $this->assertTrue($this->adapter->isUploaded());
    }

    public function testFileIsNotUploaded()
    {
        $this->assertFalse($this->adapter->isUploaded('imageNotUpload'));
    }

    public function testAdapterContainsFileWithName()
    {
        $this->dispatch('/learn-zf2-ajax-image-gallery/index/upload');
        $this->assertContains('test1.jpg', $this->adapter->getFileName());
    }

    public function testPostValidDataWithAjax()
    {
        $this->dispatch('/learn-zf2-ajax-image-gallery/index/index', 'POST', $_FILES, true);
        $this->assertTrue($this->getRequest()->isXmlHttpRequest());
        $this->dispatch('/learn-zf2-ajax-image-gallery/index/upload');
    }

    public function testUploadUrlMethodIsNotPost()
    {
        $this->dispatch('/learn-zf2-ajax-image-gallery/index/upload', 'GET');
        $this->assertFalse($this->getRequest()->isPost());
    }

    public function testAjaxFilesAction()
    {
        $this->dispatch('/learn-zf2-ajax-image-gallery/index/files', 'GET', array(), true);
        $this->assertTrue($this->getRequest()->isXmlHttpRequest());
        $this->assertFalse($this->getRequest()->isPost());
    }

    public function testAjaxDeleteImageAction()
    {
        $this->dispatch('/learn-zf2-ajax-image-gallery/index/deleteimage', 'POST', array('img' => '/userfiles/images/test1.jpg'), true);
        $request = $this->getRequest();
        $this->assertTrue($request->isXmlHttpRequest());
        $this->assertTrue($request->isPost());

        copy('public/userfiles/test1.jpg', 'public/userfiles/images/test1.jpg');
    }
}
