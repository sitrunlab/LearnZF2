<?php

namespace LearnZF2Pagination\View\Helper;

use Zend\Http\Request;
use Zend\View\Helper\Url;
use LearnZF2Pagination\Exception;

/**
 * Similar to Zends's Url view helper but allows to inherit query params as well
 */
class QueryUrl extends Url
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function __invoke($name = null, $params = [], $options = [], $reuseMatchedParams = false)
    {
        if (null === $this->router) {
            throw new Exception\RuntimeException('No RouteStackInterface instance provided');
        }

        if (3 == func_num_args() && is_bool($options)) {
            $reuseMatchedParams = $options;
            $options = [];
        }

        // Inherit query parameters
        if ($reuseMatchedParams) {
            $providedQueryParams = isset($options['query']) ? $options['query'] : [];
            $currentQueryParams = $this->request->getQuery()->toArray();
            $options['query'] = array_merge($currentQueryParams, $providedQueryParams);
        }

        return parent::__invoke($name, $params, $options, $reuseMatchedParams);
    }
}
