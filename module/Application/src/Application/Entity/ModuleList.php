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

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleList.
 *
 * @ORM\Table(name="module_list")
 * @ORM\Entity
 */
class ModuleList
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="module_name", type="string", length=45, nullable=true)
     */
    private $moduleName;

    /**
     * @var string
     *
     * @ORM\Column(name="module_desc", type="string", length=255, nullable=true)
     */
    private $moduleDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="module_route", type="string", length=45, nullable=true)
     */
    private $moduleRoute;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set moduleName.
     *
     * @param string $moduleName
     *
     * @return ModuleList
     */
    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;

        return $this;
    }

    /**
     * Get moduleName.
     *
     * @return string
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * Set moduleDesc.
     *
     * @param string $moduleDesc
     *
     * @return ModuleList
     */
    public function setModuleDesc($moduleDesc)
    {
        $this->moduleDesc = $moduleDesc;

        return $this;
    }

    /**
     * Get moduleDesc.
     *
     * @return string
     */
    public function getModuleDesc()
    {
        return $this->moduleDesc;
    }

    /**
     * Set moduleRoute.
     *
     * @param string $moduleRoute
     *
     * @return ModuleList
     */
    public function setModuleRoute($moduleRoute)
    {
        $this->moduleRoute = $moduleRoute;

        return $this;
    }

    /**
     * Get moduleRoute.
     *
     * @return string
     */
    public function getModuleRoute()
    {
        return $this->moduleRoute;
    }
}
