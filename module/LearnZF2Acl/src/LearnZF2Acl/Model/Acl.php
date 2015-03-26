<?php

namespace LearnZF2Acl\Model;

use Zend\Permissions\Acl\Acl as BaseAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

/**
 * Acl model.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class Acl extends BaseAcl
{
    /**
     * Construct
     * Define Acl keys.
     */
    public function __construct()
    {
        $this->addRole(new Role('Guest'));
        $this->addRole(new Role('User'),  'Guest');
        $this->addRole(new Role('Admin'), 'User');

        $this->addResource(new Resource('HomeController'));
        $this->addResource(new Resource('UserController'));
        $this->addResource(new Resource('AdminController'));

        $this->allow('Guest', 'HomeController', 'ViewHome');
        $this->allow('Guest', 'UserController', ['ViewUser', 'RegisterUser']);

        $this->allow('User', 'UserController', 'EditUser');
        $this->deny('User', 'UserController', 'RegisterUser');

        $this->allow('Admin', 'AdminController', ['DeleteUser', 'AddUser']);
    }

    /**
     * Get Right lists.
     *
     * @param int $roleId
     *
     * @return array
     */
    public function getRightLists($roleId = null)
    {
        $rules = [];
        $currentRole = 'All';
        foreach ($this->getResources() as $resource) {
            foreach ($this->getRoles() as $roleKey => $role) {
                $rules[]    = $this->getRules(new Resource($resource), new Role($role));
                if ($roleId == $roleKey) {
                    $currentRole = $role;
                }
            }
        }

        $rights = [];
        foreach ($rules as $rule) {
            if (is_array($rule)) {
                foreach ($rule['byPrivilegeId'] as $right => $typeAndAssert) {
                    if (!in_array($right, $rights)) {
                        $rights[] = $right;
                    }
                }
            }
        }

        if ($roleId === null) {
            return $rights;
        }

        $rightList = [];
        foreach ($this->getResources() as $resource) {
            foreach ($rights as $key => $right) {
                if ($currentRole != 'All') {
                    if ($this->isAllowed($currentRole, $resource, $right) && !in_array($right, $rightList)) {
                        $rightList[] = $right;
                    }
                }
            }
        }

        return $rightList;
    }

    /**
     * Get Resource by Role.
     *
     * @param int $roleId
     *
     * @return array
     */
    public function getResourceByRole($roleId)
    {
        $selectedRole = 'Guest';
        foreach ($this->getRoles() as $key => $role) {
            if ($roleId == $key) {
                $selectedRole = $role;
                break;
            }
        }

        $resources = [];
        foreach ($this->getResources() as $resource) {
            foreach ($this->getRightLists() as $right) {
                if ($this->isAllowed($selectedRole, $resource, $right)) {
                    if (!in_array($resource, $resources)) {
                        $resources[] = $resource;
                    }
                }
            }
        }

        return $resources;
    }
}
