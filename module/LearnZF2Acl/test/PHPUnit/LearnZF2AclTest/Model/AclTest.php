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

namespace LearnZF2AclTest\Model;

use PHPUnit_Framework_TestCase;
use LearnZF2Acl\Model\Acl;

class AclTest extends PHPUnit_Framework_TestCase
{
    /** @var Acl */
    protected $acl;

    public function setUp()
    {
        $this->acl = new Acl();
    }

    /**
     * @return array
     */
    public function provideRoleRights()
    {
        return [
            [null, ['ViewHome', 'ViewUser', 'RegisterUser', 'EditUser', 'DeleteUser', 'AddUser']],
            [0, ['ViewHome', 'ViewUser', 'RegisterUser']],
            [1, ['ViewHome', 'ViewUser', 'EditUser']],
            [2, ['ViewHome', 'ViewUser', 'EditUser', 'DeleteUser', 'AddUser']],
        ];
    }

    /**
     * @dataProvider provideRoleRights
     */
    public function testGetRightLists($role, $result)
    {
        $this->assertEquals($result, $this->acl->getRightLists($role));
    }

    /**
     * @return array
     */
    public function provideRoleResources()
    {
        return [
            [0, ['HomeController', 'UserController']],
            [1, ['HomeController', 'UserController']],
            [2, ['HomeController', 'UserController', 'AdminController']],
        ];
    }

    /**
     * @dataProvider provideRoleResources
     */
    public function testGetResourceByRole($role, $result)
    {
        $this->assertEquals($result, $this->acl->getResourceByRole($role));
    }
}
