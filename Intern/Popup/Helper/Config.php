<?php
/**
 * Intern LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://store.Intern.com/Intern-LICENSE-COMMUNITY.txt
 *
 ********************************************************************
 * @category   Intern
 * @package    Intern_Popup
 * @copyright  Copyright (c) Intern LLC. (http://www.Intern.com)
 * @license    http://store.Intern.com/Intern-LICENSE-COMMUNITY.txt
 */
namespace Intern\Popup\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Config
 * @package Intern\Popup\Helper
 */
class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * Config constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager
    )
    {
        parent::__construct($context);
        $this->storeManager = $storeManager;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return ($this->getConfig('enabled')) ? TRUE : FALSE;
    }

    /**
     * @return string
     */
    public function getConfigPath() {
        return  'promopopup/settings/';
    }

    /**
     * @param $field
     * @param null $store
     * @return mixed
     */
    public function getConfig($field)
    {
        return $this->scopeConfig->getValue(
            $this->getConfigPath() . $field,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );
    }

}
