<?php
/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 04/12/15
 * Time: 19:26
 */

namespace Core;


class DatabaseChecker
{
    private $host;
    private $dbname;
    private $user;
    private $password;

    private $bdd;

    public function __construct($dbhost, $dbname, $user, $password)
    {
        $this->host = $dbhost;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;

        $this->bdd = Connexion::getConnexion($dbhost, $dbname, $user, $password);

    }

    public function listAllTables()
    {
        $req = $this->bdd->prepare("SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE FROM `information_schema`.`COLUMNS` WHERE TABLE_SCHEMA LIKE :db ");
        $req->execute([
            "db" => $this->dbname,
        ]);

        return $req->fetchAll();
    }

    public function listThisTable($dbhost, $dbname, $dbuser, $dbpass, $tablename)
    {
        $req = $this->bdd->prepare("SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE FROM `information_schema`.`COLUMNS` WHERE TABLE_SCHEMA LIKE :db AND TABLE_NAME LIKE :table");
        $req->execute([
           "db" => $this->dbname,
            "table" => $tablename
        ]);

        return $req->fetchAll();
    }

    public function checkIfExist($database)
    {
        $req = $this->bdd->prepare("SELECT COUNT(*) as 'count' FROM `information_schema`.`SCHEMATA` WHERE `SCHEMA_NAME` LIKE :db");
        $req->execute([
            "db" => $database,
        ]);

        return $req->fetch()['count'];
    }
}