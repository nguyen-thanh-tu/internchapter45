<?php

namespace Intern\Chapter9\Model\ResourceModel\MagenestBlog;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('Intern\Chapter9\Model\MagenestBlog', 'Intern\Chapter9\Model\ResourceModel\MagenestBlog');
    }
}
