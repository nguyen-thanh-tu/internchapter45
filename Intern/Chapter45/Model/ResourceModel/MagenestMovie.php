<?php
namespace Intern\Chapter45\Model\ResourceModel;

class MagenestMovie extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('magenest_movie', 'movie_id');
    }
}
