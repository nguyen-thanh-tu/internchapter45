<?php

namespace Intern\Chapter45\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Filesystem;

class AdminSaveCustomer implements \Magento\Framework\Event\ObserverInterface
{
    public function __construct(
        Filesystem $filesystem
    ) {
        $this->mediaDirectory = $filesystem->getDirectoryWrite('media');
    }

    public function execute(Observer $observer)
    {
        $customer = ($observer->getData())['customer'];
        $avatar = ($customer->getCustomAttribute('avatar'))->getValue();
        $originPath = $this->mediaDirectory->getAbsolutePath();
        $result = $this->mediaDirectory->copyFile($originPath.'customer'.$avatar,
            $originPath.'magenestimage'.$avatar
        );
        return $observer;
    }
}
