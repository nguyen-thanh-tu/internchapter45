<?php

namespace Intern\CustomizeInAdminhtml\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;

class CustomerGroupColumn extends Select
{
    /**
     * Customer Group
     *
     * @var \Magento\Customer\Model\ResourceModel\Group\Collection
     */

    protected $_customerGroup;

    public function __construct
    (
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Customer\Model\ResourceModel\Group\Collection $customerGroup,
        array $data = []
    )
    {
        $this->_customerGroup = $customerGroup;
        parent::__construct($context, $data);
    }
    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Set "id" for <select> element
     *
     * @param $value
     * @return $this
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    private function getSourceOptions(): array
    {
        $customerGroupData = $this->_customerGroup->getData();
        $result = [];
        foreach($customerGroupData as $customer)
        {
            $result[] = ['label' => $customer['customer_group_code'], 'value' => $customer['customer_group_id']];
        }
        return $result;
    }
}

