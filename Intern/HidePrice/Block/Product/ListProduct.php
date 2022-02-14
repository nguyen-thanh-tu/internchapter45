<?php

namespace Intern\HidePrice\Block\Product;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    const HIDEPRICECATEGORY = 'hide_price/general/enable_product_price_category_page';

    public function hidePriceCategory()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $scopeConfig = $objectManager->create(\Magento\Framework\App\Config\ScopeConfigInterface::class);
        return $scopeConfig->getValue(static::HIDEPRICECATEGORY);
    }
}
