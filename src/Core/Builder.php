<?php
/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 09/12/15
 * Time: 11:54
 */
namespace Core;

use \Core\Connexion;
use Core\AwHPDO;

class Builder
{
    private $bdd;

    public function __construct()
    {
        $this->bdd = new \Core\AwHPDO('mysql:host=127.0.0.1;dbname=test_orm', 'root', 'root', [
            \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION
        ]);
    }

    public function hydrateEntity($entity)
    {
        $tableName = get_class($entity);
        $tableName = explode("\\", $tableName)[1];
        $query = "SELECT * FROM ".$tableName;
        $req = $this->bdd->prepareQuery($query);
        $req->execute();
        return $req->fetchAll();
    }

    protected function selectData($datas, $clauses)
    {
        $query = $this->queryGenerator("SELECT", $datas, $clauses);
        $req = $this->bdd->prepareQuery($query);
        $req->execute();
        return $req->fetchAll();
    }

    protected function insertData($datas)
    {
        $query = $this->queryGenerator("INSERT", $datas, []);
        $datas = get_object_vars($datas);
        $req = $this->bdd->prepareQuery($query);
        return $req->execute($datas);
    }

    protected function updateData($datas,Array $clauses)
    {
        $query = $this->queryGenerator("DELETE", $datas, $clauses);
        $datas = get_object_vars($datas);
        $req = $this->bdd->prepareQuery($query);

        return $req->execute($datas);
    }

    protected function deleteData($data, $clauses)
    {
        $query = $this->queryGenerator("DELETE", $data, $clauses);
        $req = $this->bdd->prepareQuery($query);
        return $req->execute();
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

    private function getClass($class)
    {
        return $className = get_class($class);
    }

    private function queryGenerator($type, $datas, Array $clauses)
    {
        $className = $this->getClass($datas);
        $tableName = explode("\\", get_class($datas))[1];
        $element = get_class_vars($className);

        switch($type)
        {
            case "SELECT":
                $query = "SELECT * FROM ".$tableName;
                $tableElement = $this->getTableElements($element);
                $i = 0;
                $elemLength = count($tableElement);
                foreach ($clauses as $clause => $elem)
                {
                    $query .= ($i == $elemLength-1) ? "fin" : " ".$clause." ".$elem;
                    $i++;
                }
                return $query;
                break;
            case "INSERT":
                $query = "INSERT INTO ".$tableName." (";
                $tableElement = $this->getTableElements($element);
                $i = 0;
                $elemLength = count($tableElement);
                foreach ($tableElement as $elements => $elem)
                {
                    $query .= ($i == $elemLength-1) ? "`" . $elem . "`" : "`" . $elem . "`,";
                    $i++;
                }
                $query .= " ) VALUES (";
                $i = 0;
                $dataLength = count($element);
                foreach ($datas as $data => $d) {
                    $query .= ($i == $dataLength-1) ? ":".$data : ":".$data.", ";
                    $i++;
                }
                $query .= ");";
                return $query;
                break;
            case "UPDATE":
                $query = "UPDATE ".$tableName." SET ";
                $i = 0;
                $elemLength = count($datas);
                foreach ($datas as $data => $d)
                {
                    $query .= ($i == $elemLength-1) ? "`" . $data . "` = :".$data." " : ",`".$data."` = :".$data."";
                    $i++;
                }
                if(!empty($clauses))
                {
                    foreach ($clauses as $clause => $c)
                    {
                        $query .= " ".$clause." ".$c;
                        $i++;
                    }
                }
                return $query;
                break;
            case "DELETE":
                $query = "DELETE FROM ".$tableName." ";
                foreach ($clauses as $clause => $c) {
                    $query .= " ".$clause." ".$c;
                }
                return $query;
                break;
            default:
                return "ERROR";
                break;
        }
    }
}
