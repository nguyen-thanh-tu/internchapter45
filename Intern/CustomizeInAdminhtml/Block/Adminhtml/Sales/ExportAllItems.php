<?php
namespace Intern\CustomizeInAdminhtml\Block\Adminhtml\Sales;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\AuthorizationInterface;

class ExportAllItems implements ButtonProviderInterface
{
    /**
     * @var AuthorizationInterface
     */
    private $authorization;

    /**
     * @var Context
     */
    private $context;

    /**
     * CustomButton constructor.
     *
     * @param AuthorizationInterface $authorization
     * @param Context $context
     */
    public function __construct(
        AuthorizationInterface $authorization,
        Context $context
    ) {
        $this->authorization = $authorization;
        $this->context = $context;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        if (!$this->authorization->isAllowed('Magento_Cms::save')) {
            return [];
        }

        return [
            'label' => __('Export All Item'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->context->getUrlBuilder()->getUrl('customizeadminhtml/sales/exportallitems', []);
    }
}
