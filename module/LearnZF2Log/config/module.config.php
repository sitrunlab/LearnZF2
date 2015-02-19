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
return [
    // setup log abstract service
    'log' => [
        'Tutorial-Logger' => [
            'writers' => [
                [
                    'name' => 'stream',
                    'options' => [
                        'stream' => 'php://output',
                        'filters' => [
                            'priority' => [
                                'name' => 'priority',
                                'options' => [
                                    'priority' => \Zend\Log\Logger::DEBUG,
                                ],
                            ],
                        ],
                        'formatter' => [
                            'name' => 'simple',
                            'options' => [
                                'format' => '%timestamp% %priorityName% (%priority%): %message%'.PHP_EOL,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'router' => [
        'routes' => [
            'learn-zf2-log' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/learn-zf2-log',
                    'defaults' => [
                        '__NAMESPACE__' => 'LearnZF2Log\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'LearnZF2Log\Controller\Index' => 'LearnZF2Log\Factory\Controller\IndexControllerFactory',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'learnzf2log' => __DIR__.'/../view',
        ],
    ],
];
