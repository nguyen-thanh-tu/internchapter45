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

namespace Intern\Popup\Model\Config\Source;

/**
 * Class CartRules
 * @package Intern\ThankYouPage\Model\Config\Source
 */
class CartRules implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var array
     */
    protected $_options;


    /**
     * Collection object
     *
     * @var \Magento\Framework\Data\Collection
     */
    protected $_collection;


    /**
     * CartRules constructor.
     * @param \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory $collectionFactory
    ) {
        $this->_collection = $collectionFactory->create();
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function toOptionArray()
    {
        if (!$this->_options) {
            $this->_options = [];
            foreach ($this->_collection->getItems() as $item) {
                $id = $item->getRuleId();
                $name = $item->getName();
                $this->_options[] = ['value' => $id, 'label' => $name];
            }
        }
        return $this->_options;
    }
}
