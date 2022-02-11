<?php

namespace Intern\Banner\Block\Adminhtml\Index\Edit;

use Magento\Backend\Block\Widget\Context;

class GenericButton
{

    protected $context;
    protected $bannerFactory;

    public function __construct(
        Context $context,
        \Intern\Banner\Model\BannerFactory $bannerFactory
    )
    {
        $this->context = $context;
        $this->bannerFactory = $bannerFactory;
    }

    /**
     * Return Banner ID
     */
    public function getBannerId()
    {
        $id = $this->context->getRequest()->getParam('id');
        $banner = $this->bannerFactory->create()->load($id);
        if ($banner->getId())
            return $id;
        return null;
    }

    /**
     * Generate url by route and parameters
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
