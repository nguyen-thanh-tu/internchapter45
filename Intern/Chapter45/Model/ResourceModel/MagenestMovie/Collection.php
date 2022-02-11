<?php

namespace Intern\Chapter45\Model\ResourceModel\MagenestMovie;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'movie_id';

    protected function _construct()
    {
        $this->_init('Intern\Chapter45\Model\MagenestMovie', 'Intern\Chapter45\Model\ResourceModel\MagenestMovie');
    }

    protected function _initSelect()
    {
        parent::_initSelect();
        $john = $this->getSelect()->joinLeft(
            ['movie_director' => $this->getTable('magenest_director')],
            'main_table.director_id = movie_director.director_id');
        return $this;
    }

    public function getActorByMovieId($movieId)
    {
        $collection = $this->join(
            ['movie_actor' => $this->getTable('magenest_movie_actor')],
            'main_table.movie_id = movie_actor.movie_id AND main_table.movie_id ='. $movieId)
            ->join(
                ['actor' => $this->getTable('magenest_actor')],
                'movie_actor.actor_id = actor.actor_id',
                ['name_actor' => 'actor.name']
            );
        return $collection;
    }
}
