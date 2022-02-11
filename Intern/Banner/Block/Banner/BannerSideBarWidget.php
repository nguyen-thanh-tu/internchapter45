<?php

namespace Intern\Banner\Block\Banner;

use Intern\Banner\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class BannerSideBarWidget extends Template implements BlockInterface
{

    protected $bannerCollectionFactory;

    public function __construct(
        Template\Context $context,
        array $data,
        CollectionFactory $bannerCollectionFactory)
    {
        $this->setTemplate('bannersidebarwidget.phtml');
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Set data to View
     */
    protected function _beforeToHtml()
    {
        // Init collection
        $collection = $this->bannerCollectionFactory->create();

        // Get enabled images
        $banners = $collection->addFieldToFilter('status', ['eq' => true])->getData();

        // Set data
        $this->setData('banners', $banners);
        $this->setData('mediaURL', $this->_storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'banner/images/');

        // Return to View
        return parent::_beforeToHtml();
    }
}
