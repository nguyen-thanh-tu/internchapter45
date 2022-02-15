<?php

namespace Intern\CustomizeInAdminhtml\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Filesystem;
use Magento\Framework\Exception\LocalizedException;

class AdminSaveCustomer implements \Magento\Framework\Event\ObserverInterface
{
    protected $customer;

    protected $customerFactory;

    protected $filesystem;

    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Model\Customer $customer,
        \Magento\Framework\Filesystem $filesystem
    )
    {
        $this->customer = $customer;
        $this->_customerRepository = $customerRepository;
        $this->filesystem = $filesystem;
    }


    public function execute(Observer $observer)
    {
        $meditaDirectory = $this->filesystem->getDirectoryWrite('media');

        $requestCustomer = $observer->getData('request')->getParam('customer');

        $customerId = $requestCustomer['entity_id'];

        $customtab = $observer->getData('request')->getParam('customtab');

        $customer = $this->_customerRepository->getById($customerId);

        if(isset($customtab['imagessss']))
        {
            $filename = $customtab['imagessss'][0]['name'];
            $customer->setCustomAttribute('imagessss','/'.$filename[0].'/'.$filename[1].'/'.$filename);
            $originPath = $meditaDirectory->getAbsolutePath();
            $meditaDirectory->copyFile($originPath.'magenestimage/tmp/'.$filename,
                $originPath.'customer'.'/'.$filename[0].'/'.$filename[1].'/'.$filename
            );
            $meditaDirectory->copyFile($originPath.'magenestimage/tmp/'.$filename,
                $originPath.'magenestimage'.'/'.$filename[0].'/'.$filename[1].'/'.$filename
            );
        }else{
            $customer->setCustomAttribute('imagessss','');
        }
        $this->_customerRepository->save($customer);
    }
}
