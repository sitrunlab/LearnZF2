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

namespace LearnZF2Acl\Controller;

use LearnZF2Acl\Model\Acl;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Acl Controller.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class AclController extends AbstractActionController
{
    /**
     * @var Acl
     */
    private $aclmodel;

    /**
     * Construct.
     *
     * @param Acl $aclmodel
     */
    public function __construct(Acl $aclmodel)
    {
        $this->aclmodel = $aclmodel;
    }

    public function indexAction()
    {
        $defaultSelectedRoleId = 0;

        return new ViewModel([
            'defaultSelectedRoleId' => $defaultSelectedRoleId,
            'roles' => $this->aclmodel->getRoles(),
            'resources' => $this->aclmodel->getResources(),
            'rights' => $this->aclmodel->getRightLists(),
            'resourcesSelected' => $this->aclmodel->getResourceByRole($defaultSelectedRoleId),
            'rightsSelected' => $this->aclmodel->getRightLists($defaultSelectedRoleId),
        ]);
    }

    public function listresourcesandrightsAction()
    {
        $resources = [];
        $rights = [];

        if ($this->request->isPost()) {
            $roleId = $this->request->getPost('roleId', 0);

            $resources = $this->aclmodel->getResourceByRole($roleId);
            $rights = $this->aclmodel->getRightLists($roleId);
        }

        return new JsonModel([
            'resources' => $resources,
            'rights' => $rights,
        ]);
    }
}
