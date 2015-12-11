<?php
/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 09/12/15
 * Time: 11:54
 */

namespace QueryBuilder;

use Core\Connexion;

class Builder
{
    private $bdd;

    public function __construct()
    {
        $this->bdd = Connexion::getConnexion("127.0.0.1", "test_orm", "root","root");
    }

    public function getAll($table)
    {
        $req = $this->bdd->prepare("SELECT * FROM ".$table);
        $req->execute();

        return $req->fetchAll();
    }

    public function insertData($datas)
    {
        $query = $this->getInsertQuery($datas);
        $req = $this->bdd->prepare($query);
        return $req->execute();
    }

    public function updateData($data, $clause)
    {
        var_dump($data, $clause);
        return true;
    }

    private function getInsertQuery($datas)
    {
        $className = get_class($datas);
        $tableName = explode("\\", get_class($datas))[1];
        $element = get_class_vars($className);
        $query = "INSERT INTO ".$tableName." (";
        $tableElement = $this->getTableElements($element);

        $i = 0;
        $elemLength = count($tableElement);
        foreach ($tableElement as $elements => $elem)
        {
            if($i == $elemLength-1) {
                $query .= "`" . $elem . "` ";
            }else{
                $query .= "`" . $elem . "`, ";
            }
            $i++;
        }
        $query .= " ) VALUES (";

        $i = 0;
        $dataLength = count($element);

        foreach ($datas as $data => $d) {
            if($i == $dataLength-1){
                $query .= "\"".$d."\" ";
            }
            else {
                $query .= "\"".$d."\", ";
            }
            $i++;
        }
        $query .= ");";

        return $query;
    }

    protected function getTableElements($datas)
    {
        $var = [];
        foreach ($datas as $data => $d)
        {
            $var[] = $data;
        }
        return $var;
    }
}