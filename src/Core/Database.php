<?php

namespace Core;

class Database
{

    private $fields;
    private $bdd;

    public function __construct($host, $dbname, $dbuser, $dbpass)
    {
        $this->bdd = Connexion::getConnexion($host, $dbname, $dbuser, $dbpass);
    }

    public function hydrate(Object $object)
    {

    }

    public function deleteTable($dbname)
    {
        try{
            $req = $this->bdd->prepare("DROP TABLE ".$dbname);
            $req->execute();
            return true;
        } catch (\PDOException $e){
            return "ERROR ".$e->getMessage();
        }
    }

    public function createTable($name, Array $fields)
    {
        try {
            $this->getFields($name, $fields);

            $query = "CREATE TABLE ".$name." (
          id int NOT NULL AUTO_INCREMENT,";
            foreach ($fields as $field => $f) {
                $query .="\n".$f['name']." ".$f['type']." NOT NULL,\n";
            }

            $query .= "PRIMARY KEY `id`(`id`)
        ) ENGINE = INNODB DEFAULT CHARSET = utf8;";


            $req = $this->bdd->prepare($query);
            $req->execute();
            return true;
        } catch (\PDOException $e){
            return "ERROR ".$e->getMessage();
        }
    }

    public function getFields($dbname, &$fields){
        $name = readline("Nom du champs : ");
        $type = readline("Type du champs [int, string, date, datetime, bool] : ");
        $else = readline("Souhaitez-vous ajouter un champs ? [y/N]");

        if(isset($name, $type) && !empty($name) && !empty($type)){

            switch($type){
                case "int":
                    $type = "int(11)";
                    break;
                case "string":
                    $type = "varchar(255)";
                    break;
                case "bool":
                    $type = "tinyint(1)";
                    break;
                case "date":
                    $type = "date";
                    break;
                case "datetime":
                    $type = "datetime";
                    break;
                default:
                    return "Ce champs n'existe pas";
                    break;
            }

            array_push($fields, ["name" => $name, "type" => $type]);
            if($else == "Y" || $else == "y"){
                $this->getFields($dbname, $fields);
                return true;
            } else {
                return false;
            }
        } else{
            return false;
        }

    }


}