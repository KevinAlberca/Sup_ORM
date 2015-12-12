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

    protected function getAll($entity)
    {
        $table = explode("\\", get_class($entity))[1];
        $req = $this->bdd->prepare("SELECT * FROM ".$table);
        $req->execute();

        $object = new $entity();

        foreach ($req->fetchAll() as $item => $iValue)
        {
            $object->$item = $iValue;
        }
        return $object;
    }

    protected function selectData($datas, $clauses)
    {
        return $this->queryGenerator("SELECT", $datas, $clauses);
    }

    protected function insertData($datas)
    {
        $query = $this->queryGenerator("INSERT", $datas, []);
        $datas = get_object_vars($datas);
        $req = $this->bdd->prepare($query);
        return $req->execute($datas);
    }

    protected function updateData($datas,Array $clauses)
    {
        $query = $this->queryGenerator("DELETE", $datas, $clauses);
        $datas = get_object_vars($datas);
        $req = $this->bdd->prepare($query);

        return $req->execute($datas);
    }

    protected function deleteData($data, $clauses)
    {
        $query = $this->queryGenerator("DELETE", $data, $clauses);
        $req = $this->bdd->prepare($query);
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
