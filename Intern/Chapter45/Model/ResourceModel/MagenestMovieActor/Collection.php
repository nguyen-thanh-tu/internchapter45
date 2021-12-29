<?php

namespace Intern\Chapter45\Model\ResourceModel\MagenestMovieActor;

class Collection
{
    protected $resourceConnection;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resourceConnection
    )
    {
        $this->resourceConnection = $resourceConnection;
    }

    public function insertToTable($valueInBrackets)
    {
//        ('6','8'),('6','9'),('6','10'),('6','11')
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('magenest_movie_actor');
        $sql = "INSERT INTO " . $tableName . "(movie_id,actor_id) VALUES".$valueInBrackets;
        $connection->query($sql);
    }

    public function getDataByMovieId($movieId)
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('magenest_movie_actor');
        $sql = "SELECT * FROM " .$tableName. " WHERE movie_id = " .$movieId;
        $connection->query($sql);
        return $connection->fetchAll($sql);
    }
}
