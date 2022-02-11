<?php

namespace Intern\CustomizeInAdminhtml\Model\ResourceModel;

class ReferencesFile extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('references_file', 'references_file_id');
    }
}
