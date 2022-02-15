<?php

namespace Intern\CustomizeInAdminhtml\Model\ResourceModel\ReferencesLink;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'references_link_id';

    protected function _construct()
    {
        $this->_init('Intern\CustomizeInAdminhtml\Model\ReferencesLink', 'Intern\CustomizeInAdminhtml\Model\ResourceModel\ReferencesLink');
    }

    public function getDataByProductId($product_id)
    {
        $connection = $this->getConnection();
        $tableName = 'references_link';
        $sql = "SELECT * FROM " .$tableName. " WHERE product_entity_id = " .$product_id;
        $connection->query($sql);
        return $connection->fetchAll($sql);
    }


    public function deleteDataByProductId($product_id)
    {
        $connection = $this->getConnection();
        $tableName = 'references_link';
        $sql = "DELETE FROM " .$tableName. " WHERE product_entity_id = " .$product_id;
        $connection->query($sql);
    }
}
