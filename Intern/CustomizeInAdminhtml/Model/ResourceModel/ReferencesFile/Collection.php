<?php

namespace Intern\CustomizeInAdminhtml\Model\ResourceModel\ReferencesFile;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'references_file_id';

    protected function _construct()
    {
        $this->_init('Intern\CustomizeInAdminhtml\Model\ReferencesFile', 'Intern\CustomizeInAdminhtml\Model\ResourceModel\ReferencesFile');
    }

    public function getDataByProductId($product_id)
    {
        $connection = $this->getConnection();
        $tableName = 'references_file';
        $sql = "SELECT * FROM " .$tableName. " WHERE product_entity_id = " .$product_id;
        $connection->query($sql);
        return $connection->fetchAll($sql);
    }

    public function deleteDataByProductId($product_id)
    {
        $connection = $this->getConnection();
        $tableName = 'references_file';
        $sql = "DELETE FROM " .$tableName. " WHERE product_entity_id = " .$product_id;
        $connection->query($sql);
    }
}
