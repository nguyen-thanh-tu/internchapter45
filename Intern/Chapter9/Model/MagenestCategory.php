<?php

namespace Intern\Chapter9\Model;

class MagenestCategory extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Intern\Chapter9\Model\ResourceModel\MagenestCategory');
    }
}
