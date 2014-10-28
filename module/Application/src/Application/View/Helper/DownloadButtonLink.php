<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class DownloadButtonLink extends AbstractHelper
{
    /**
     * Download link
     * @param string $compress 'zip' | 'tgz' | other to make option
     * @return string
     */
    public function __invoke($compress = 'zip')
    {
        $path = $this->view->basePath();
        return $this->url('download', array('module' => $path, 'compress' => $compress));
    }
}
