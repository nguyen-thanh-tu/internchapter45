<?php

namespace Intern\Chapter45\Observer;

use Magento\Framework\Event\Observer;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;

class ChangeName implements \Magento\Framework\Event\ObserverInterface
{
    protected $_customerRepoInterface;
    protected $_customerFactory;

    public function __construct(
        CustomerRepositoryInterface $customerRepoInterface,
        StoreManagerInterface $storeRepoInterface
    ) {
        $this->_customerRepoInterface = $customerRepoInterface;
        $this->_storeRepoInterface = $storeRepoInterface;
    }

    public function execute(Observer $observer)
    {
        $websiteId = $this->_storeRepoInterface->getStore()->getWebsiteId();
        $customerEmail = $observer->getData('email');

        $custo = $this->_customerRepoInterface->get($customerEmail, $websiteId);
        $custo->setFirstname("Magento");
        $this->_customerRepoInterface->save($custo);
        return $observer;
    }
}
