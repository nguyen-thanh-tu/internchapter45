<?php

namespace Intern\Chapter45\Controller\Adminhtml\Movie;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\Request\Http;

class AddNewActor extends \Magento\Backend\App\Action
{
    protected $_pageFactory;
    protected $request;
    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory,
        Http $request
    )
    {
        $this->request = $request;
        $this->_pageFactory = $pageFactory;
        parent::__construct($context);
    }
// them construct thi xóa generated/*
    public function execute()
    {
        $id = $this->request->getParam('id');
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        if(empty($id)){
            $resultPage->getConfig()->getTitle()->prepend(__('Add Actor'));
        }else{
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Actor'));
        }
        return $resultPage;
    }
}
