<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Intern\Chapter45\Model\Config\Source;

/**
 * @api
 * @since 100.0.2
 */
class Show implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 1, 'label' => __('Show')], ['value' => 2, 'label' => __('Not Show')]];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [1 => __('Show'), 2 => __('Not Show')];
    }
}

