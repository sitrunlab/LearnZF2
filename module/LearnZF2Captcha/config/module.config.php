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
return [
    'router' => [
        'routes' => [

            'learn-zf2-captcha' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/learn-zf2-captcha',
                    'defaults' => [
                        '__NAMESPACE__' => 'LearnZF2Captcha\Controller',
                        'controller' => 'Captcha',
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            'LearnZF2Captcha\Controller\Captcha' => 'LearnZF2Captcha\Factory\Controller\CaptchaControllerFactory',
        ],
    ],

    'form_elements' => [
        'factories' => [
            'LearnZF2Captcha\Form\CaptchaForm' => 'LearnZF2Captcha\Factory\Form\CaptchaFormFactory',
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'learn-zf2-captcha' => __DIR__.'/../view',
        ],
    ],
];
