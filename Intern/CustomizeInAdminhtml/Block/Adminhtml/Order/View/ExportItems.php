<?php

namespace Intern\CustomizeInAdminhtml\Block\Adminhtml\Order\View;

class ExportItems extends \Magento\Sales\Block\Adminhtml\Items\AbstractItems
{
    /**
     * Sales data
     *
     * @var \Magento\Sales\Helper\Data
     */
    protected $_urlBuilder;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry
     * @param \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Sales\Helper\Data $urlBuilder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Model\UrlInterface $urlBuilder,
        array $data = []
    ) {
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $stockRegistry, $stockConfiguration, $registry, $data);
    }


    public function getUrlMethod()
    {
        return $this->_urlBuilder->getRouteUrl(
            'customizeadminhtml/order/exportitems',
            [
                'order_id'=> $this->getOrderData('entity_id'),
                'key'=>$this->_urlBuilder->getSecretKey('customizeadminhtml','order','exportitems')
            ]
        );
    }
    public function getOrderData($key)
    {
        return $this->getOrder()->getData($key);
    }
}
