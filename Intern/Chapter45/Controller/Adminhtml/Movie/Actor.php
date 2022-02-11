<?php

namespace Intern\Chapter45\Controller\Adminhtml\Movie;

use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Actor extends \Magento\Backend\App\Action
{
    protected $_pageFactory;

    public function __construct(Action\Context $context, PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->_pageFactory->create();
    }
}

