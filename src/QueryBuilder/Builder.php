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
    public $table;
    public $clause;
    public $data = [];
    public $query;

    private $bdd;

    public function __construct()
    {
        $this->bdd = Connexion::getConnexion("127.0.0.1", "test_orm", "root","root");
    }

    public function table($table)
    {
        $this->table = strtolower($table);
        return $this;
    }

    public function clause($clause)
    {
        $this->clause = $clause;
        return $this;
    }

    public function getAll($table)
    {
        $req = $this->bdd->prepare("SELECT * FROM ".$table);
        $req->execute();

        return $req->fetchAll();
    }

    public function get($tableName,Array $options, $clause = null)
    {
        $i = 0;
        $len = count($options);
        $this->query = "SELECT ";
        foreach ($options as $option) {
            if($i == $len - 1){
                $this->query .= $option." ";
            } else {
                $this->query .= $option.", ";
            }
            $i++;
        }
       $this->query .= " FROM ".$tableName.";";

        return $this;

    }

    public function insert($datas)
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

    private function getTableElements($datas)
    {
        $var = [];
        foreach ($datas as $data => $d)
        {
            $var[] = $data;
        }
        return $var;
    }
}