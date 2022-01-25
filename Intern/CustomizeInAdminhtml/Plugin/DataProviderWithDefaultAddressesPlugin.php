<?php

namespace Intern\CustomizeInAdminhtml\Plugin;

use Magento\Customer\Model\Customer\DataProviderWithDefaultAddresses;
use Magento\Store\Model\StoreManagerInterface;

class DataProviderWithDefaultAddressesPlugin
{
    protected $storeManager;
    public function __construct
    (
        StoreManagerInterface $storeManager
    )
    {
        $this->storeManager = $storeManager;
    }

    public function afterGetData(
        DataProviderWithDefaultAddresses $subject,
        array $result
    )
    {
        $currentStore = $this->storeManager->getStore();
        $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        foreach ($result as $customer_id => $customer)
        {
            if(isset($customer['customer']['imagessss'][0]['file']))
            {
                $customer['customtab']['imagessss'][0] = [
                    'name' => $customer['customer']['imagessss'][0]['name'],
                    'url' => $mediaUrl.'magenestimage/'.$customer['customer']['imagessss'][0]['file']
                ];
                $result[$customer_id] = $customer;
            }
        }

        return $result;
    }
}
