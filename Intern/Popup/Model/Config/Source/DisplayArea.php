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
 * Class DisplayArea
 * @package Intern\Popup\Model\Config\Source
 */
class DisplayArea implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'all', 'label' => __('All Pages')],
            ['value' => 'home', 'label' => __('Home Page')],
            ['value' => 'checkout', 'label' => __('Checkout (Shopping Cart)')],
        ];
    }
}
