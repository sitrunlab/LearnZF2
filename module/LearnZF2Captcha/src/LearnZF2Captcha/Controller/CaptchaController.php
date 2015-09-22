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

namespace LearnZF2Captcha\Controller;

use LearnZF2Captcha\Form\CaptchaForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/*
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class CaptchaController extends AbstractActionController
{
    /**
     * @var CaptchaForm
     */
    private $captchaForm;

    public function __construct(CaptchaForm $captchaForm)
    {
        $this->captchaForm = $captchaForm;
    }

    public function indexAction()
    {
        $form = $this->captchaForm;
        $request = $this->getRequest();

        $isValid = false;
        if ($request->isPost()) {
            $form->setAttribute('method', 'post');

            $form->setData($request->getPost());
            $isValid = $form->isValid();

            $form->setAttribute('method', 'get');
        }

        return new ViewModel(array(
            'form' => $form,
            'isValid' => $isValid,
            'isPost' => $request->isPost(),
        ));
    }
}
