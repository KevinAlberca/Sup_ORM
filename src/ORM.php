<?php

/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 09/12/15
 * Time: 18:54
 */

use Core\Builder;


class ORM extends Builder
{
  public function __construct($dbhost, $dbname, $dbuser, $dbpass)
  {
    //var_dump($dbhost, $dbname, $dbuser, $dbpass);

    parent::__construct($dbhost, $dbname, $dbuser, $dbpass);
  }
    public function getAll($entity)
    {
        return $this->hydrateEntity($entity);
    }

    public function select($datas, $clauses)
    {
        return $this->selectData($datas, $clauses);
    }

    public function save($data)
    {
        return $this->insertData($data);
    }

    public function update($data, $clause)
    {
        return $this->updateData($data, $clause);
    }

    public function delete($data, Array $clause)
    {
        return $this->deleteData($data, $clause);
    }
}
