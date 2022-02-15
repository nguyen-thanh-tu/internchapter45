<?php

namespace Intern\Banner\Model\Config\Source;

class Banner implements \Magento\Framework\Option\ArrayInterface
{
    protected $bannerCollection;

    public function __construct(
        \Intern\Banner\Model\ResourceModel\Banner\CollectionFactory $bannerCollection
    )
    {
        $this->bannerCollection = $bannerCollection->create();
    }
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $optionArray = [];
        foreach($this->bannerCollection->getData() as $banner)
        {
            if($banner['status'] == 1)
            {
                $optionArray[] = ['value' => $banner['image'], 'label' => __($banner['title'])];
            }
        }
        return $optionArray;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach($this->bannerCollection->getData() as $banner)
        {
            if($banner['status'] == 1)
            {
                $array[$banner['image']] = __($banner['title']);
            }
        }
        return $array;
    }
}
