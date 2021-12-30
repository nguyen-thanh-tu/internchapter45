<?php

namespace Intern\Chapter45\Model\ResourceModel\MagenestActor;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'actor_id';

    protected function _construct()
    {
        $this->_init('Intern\Chapter45\Model\MagenestActor', 'Intern\Chapter45\Model\ResourceModel\MagenestActor');
    }
}
