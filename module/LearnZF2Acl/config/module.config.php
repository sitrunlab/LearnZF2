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

            'learn-zf2-acl' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/learn-zf2-acl',
                    'defaults' => array(
                        '__NAMESPACE__' => 'LearnZF2Acl\Controller',
                        'controller' => 'Acl',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'listresourcesandrights' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/listresourcesandrights',
                            'defaults' => array(
                                'action' => 'listresourcesandrights',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'factories' => array(
            'LearnZF2Acl\Controller\Acl' => 'LearnZF2Acl\Factory\Controller\AclControllerFactory',
        ),
    ),

    'service_manager' => array(
        'invokables' => array(
            'aclmodel' => 'LearnZF2Acl\Model\Acl',
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'learn-zf2-acl' => __DIR__.'/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
