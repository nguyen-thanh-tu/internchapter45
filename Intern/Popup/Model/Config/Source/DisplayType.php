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
 * Class DisplayType
 * @package Intern\Popup\Model\Config\Source
 */
class DisplayType implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'banner', 'label' => __('Banner')],
            ['value' => 'coupon', 'label' => __('Promo coupon')],
            ['value' => 'newsletter', 'label' => __('Newsletter')],
        ];
    }
}
