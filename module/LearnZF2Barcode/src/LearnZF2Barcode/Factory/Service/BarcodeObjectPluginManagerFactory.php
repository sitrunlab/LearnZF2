<?php

namespace LearnZF2Barcode\Factory\Service;

use Zend\Mvc\Service\AbstractPluginManagerFactory;

class BarcodeObjectPluginManagerFactory extends AbstractPluginManagerFactory
{
    const PLUGIN_MANAGER_CLASS = 'Zend\Barcode\ObjectPluginManager';
}
