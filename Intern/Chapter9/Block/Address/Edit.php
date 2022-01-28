<?php

namespace Intern\Chapter9\Block\Address;

use Magento\Framework\UrlInterface;

class Edit extends \Magento\Customer\Block\Address\Edit
{
    public function getAllOptions()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        return $objectManager
            ->create('Intern\Chapter9\Model\Region\Attribute\Source\Mode')
            ->getAllOptions();
    }
}
