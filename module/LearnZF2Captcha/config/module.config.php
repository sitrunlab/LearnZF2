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
/**
 * Module config.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
return array(
    'router' => array(
        'routes' => array(

            'learn-zf2-captcha' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/learn-zf2-captcha',
                    'defaults' => array(
                        '__NAMESPACE__' => 'LearnZF2Captcha\Controller',
                        'controller' => 'Captcha',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'factories' => array(
            'LearnZF2Captcha\Controller\Captcha' => 'LearnZF2Captcha\Factory\Controller\CaptchaControllerFactory',
        ),
    ),

    'form_elements' => array(
        'factories' => array(
            'LearnZF2Captcha\Form\CaptchaForm' => 'LearnZF2Captcha\Factory\Form\CaptchaFormFactory',
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'learn-zf2-captcha' => __DIR__.'/../view',
        ),
    ),
);
