<?php

namespace LearnZF2AjaxImageGalleryTest\Controller;

use Zend\File\Transfer\Adapter;

class HttpMockAdapter extends Adapter\Http
{
    public function __construct()
    {
        parent::__construct();
    }

    public function isValidParent($files = null)
    {
        return parent::isValid($files);
    }
}
