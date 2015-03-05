<?php
namespace LearnZF2Navigation\Navigation;

use Zend\Navigation\Service\DefaultNavigationFactory;

/**
 * Class NavigationFactory.
 *
 * @author Alejandro Celaya Alastrué <alejandro@alejandrocelaya.com>
 */
class NavigationFactory extends DefaultNavigationFactory
{
    const NAME = 'navigation-example';

    /**
     * @return string
     */
    protected function getName()
    {
        return self::NAME;
    }
}
