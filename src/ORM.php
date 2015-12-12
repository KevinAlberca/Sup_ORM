<?php

/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 09/12/15
 * Time: 18:54
 */

use QueryBuilder\Builder;


class ORM extends Builder
{

    public function getTable($tableName)
    {
        $b = new QueryBuilder\Builder();
        $this->data = $b->getAll($tableName);
        return $this;
    }
    public function save($data)
    {
        return $this->insertData($data);
    }

    public function update($data, $clause)
    {
        return $this->updateData($data, $clause);
    }

    public function delete($data, $clause)
    {
        return $this->deleteData($data, $clause);
    }

}
