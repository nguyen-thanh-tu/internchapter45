<?php

namespace Intern\CustomizeInAdminhtml\Model\ResourceModel;

class ReferencesLink extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('references_link', 'references_link_id');
    }
}
