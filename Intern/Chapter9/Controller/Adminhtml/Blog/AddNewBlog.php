<?php

namespace Intern\Chapter9\Controller\Adminhtml\Blog;

use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class AddNewBlog extends \Magento\Backend\App\Action
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
