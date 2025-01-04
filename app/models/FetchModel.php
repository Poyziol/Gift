<?php

namespace app\models;

use PDO;

class FetchModel 
{
    private $db;

    //Need db of type PDO
    public function __construct(PDO $db) 
    {
        $this->db = $db;
    }

    //Gigachad boomerang class $œ(' 3 ')œ$ 
    // Dude don't be silly 😭😭
    public function boomerang($query, $fetchMode)
    {
        $DBH = $this->db;
        $STH = $DBH->prepare($query);
        $STH->execute();

        $STH->setFetchMode($fetchMode);

        $results = array();
        while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $row;
        }
        $STH->closeCursor();
        return $results;
    }
}

?>