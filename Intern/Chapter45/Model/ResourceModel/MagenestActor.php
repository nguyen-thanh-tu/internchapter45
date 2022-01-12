<?php
namespace Intern\Chapter45\Model\ResourceModel;

class MagenestActor extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('magenest_actor', 'actor_id');
    }
}
