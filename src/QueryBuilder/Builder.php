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

    public function selectData($datas, $clauses)
    {
        return $this->queryGenerator("SELECT", $datas, $clauses);
    }

    public function insertData($datas)
    {
        $query = $this->queryGenerator("INSERT", $datas, []);
        $datas = get_object_vars($datas);
        $req = $this->bdd->prepare($query);
        return $req->execute($datas);
    }

    public function updateData($datas,Array $clauses)
    {
        $query = $this->queryGenerator("UPDATE", $datas, $clauses);
        $req = $this->bdd->prepare($query);
        return $req->execute();
    }
    public function deleteData($datas, Array $clauses)
    {
        $query = $this->queryGenerator("DELETE", $datas, $clauses);
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



    public function queryGenerator($type, $datas, Array $clauses)
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
                    $query .= ($i == $elemLength-1) ? "`" . $data . "`" : "`" . $data . "`,";
                    $i++;
                }
                if(!empty($clauses))
                {
                    foreach ($clauses as $clause => $c)
                    {
                        $query .= $clause." ".$c;
                    }
                }
                return $query;
                break;
            case "DELETE":
                $query = "DELETE FROM ".$tableName." ";
                foreach ($clauses as $clause => $c)
                {
                    $query .= $clause." ".$c;
                }
                return $query;
                break;
            default:
                return "ERROR";
                break;
        }
    }
}