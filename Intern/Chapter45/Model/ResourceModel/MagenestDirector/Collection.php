<?php

namespace Intern\Chapter45\Model\ResourceModel\MagenestDirector;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'director_id';

    protected function _construct()
    {
        $this->_init('Intern\Chapter45\Model\MagenestDirector', 'Intern\Chapter45\Model\ResourceModel\MagenestDirector');
    }
}
