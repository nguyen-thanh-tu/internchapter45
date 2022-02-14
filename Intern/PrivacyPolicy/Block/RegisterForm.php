<?php

namespace Intern\PrivacyPolicy\Block;

use Magento\Framework\View\Element\Template;

class RegisterForm extends \Magento\Framework\View\Element\Template
{
    private $scopeConfig;

    const ENABLE = 'privacy_policy/general/enable';
    const CMSBLOCK = 'privacy_policy/general/cms_block';

    public function __construct
    (
        Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->scopeConfig = $scopeConfig;
    }

    public function getHtmlBlock()
    {
        $enable = $this->scopeConfig->getValue(static::ENABLE);

        if($enable == 1)
        {
            return $this->getLayout()->createBlock('Magento\Cms\Block\Block')
                ->setBlockId($this->scopeConfig->getValue(static::CMSBLOCK))
                ->toHtml();
        }
        return '';
    }
}
