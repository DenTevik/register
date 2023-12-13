<?php

namespace Core;

use PDO;

class Database
{
    public $connection;
    public $statement;

    public function __construct()
    {
        $config = require base_path('config.php');

        $dsn = 'mysql:'.http_build_query($config['database'], '', ';');

        $this->connection = new PDO($dsn, $config['db_user'], $config['db_pass'], [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ]);
    }

    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);
        
        return $this;
    }

    public function insert($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);
        
        return $this->connection->lastInsertId();
    }

    public function update($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);
        
        return true;
    }

    public function get()
    {
        return $this->statement->fetchAll();
    }

    public function find()
    {
        return $this->statement->fetch();
    }
}

class DB
{
    static public function use(){
        return new Database();
    }
}
