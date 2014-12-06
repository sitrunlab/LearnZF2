<?php
namespace LearnZF2Pagination\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    const ITEM_PER_PAGE = 4;

    /**
     * @var array
     */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function indexAction()
    {
        $data = $this->getFilteredData();
        $page = $this->params()->fromQuery('page', 1);
        // Paginate filtered data
        $paginator = new Paginator(new ArrayAdapter($data));
        $paginator->setCurrentPageNumber($page)
                  ->setItemCountPerPage(self::ITEM_PER_PAGE);

        return new ViewModel(['paginator' => $paginator]);
    }

    /**
     * @return array
     */
    protected function getFilteredData()
    {
        // Filter by category
        $category = $this->params()->fromQuery('category');
        $data = isset($category) && array_key_exists($category, $this->data) ? $this->data[$category] : array_merge(
            $this->data['movies'],
            $this->data['books'],
            $this->data['music']
        );

        // Filter by keyword
        $keyword = $this->params()->fromQuery('keyword');
        if (! isset($keyword)) {
            return $data;
        }

        // Remove those elements which doesn't accomplish the keyword condition
        foreach ($data as $key => $element) {
            if (strpos($element['title'], $keyword) === false) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
