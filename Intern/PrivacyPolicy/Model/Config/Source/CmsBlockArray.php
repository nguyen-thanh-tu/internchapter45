<?php

namespace Intern\PrivacyPolicy\Model\Config\Source;

class CmsBlockArray implements \Magento\Framework\Option\ArrayInterface
{
    protected $_blockFactory;

    public function __construct(
        \Magento\Cms\Model\BlockFactory $blockFactory,
        array $data = []
    ) {
        $this->_blockFactory = $blockFactory;
    }

    public function getCmsBlock()
    {
        return $this->_blockFactory->create()->getCollection()->getData();
    }
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $array = [];
        $array[] = ['value' => '', 'label' => __('--Select--')];
        $cms_blocks = $this->getCmsBlock();
        foreach($cms_blocks as $cms_block)
        {
            $array[] = ['value' => $cms_block['identifier'], 'label' => __($cms_block['title'])];
        }
        return $array;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        $cms_blocks = $this->getCmsBlock();
        foreach($cms_blocks as $cms_block)
        {
            $array[$cms_block['identifier']] = __($cms_block['title']);
        }
        return $array;
    }
}
