<?php

namespace Intern\Chapter45\Model;

class MagenestDirector extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Intern\Chapter45\Model\ResourceModel\MagenestDirector');
    }
}
