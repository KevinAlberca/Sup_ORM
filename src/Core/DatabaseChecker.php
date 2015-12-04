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

        $this->getConnexion();

    }

    public function listTable()
    {
        $req = $this->bdd->prepare("SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE FROM `information_schema`.`COLUMNS` WHERE TABLE_SCHEMA LIKE :db ");
        $req->execute([
            "db" => $this->dbname,
        ]);

        return $req->fetchAll();
    }

    public function checkIfExist($host, $dbname, $dbuser, $dbpass)
    {
        $req = $this->bdd->prepare("SELECT COUNT(*) as 'count' FROM `information_schema`.`SCHEMATA` WHERE `SCHEMA_NAME` LIKE :db");
        $req->execute([
            "db" => $dbname,
        ]);

        return $req->fetch()['count'];
    }

    private function getConnexion()
    {
        $db = null;
        try {
            $db = new \PDO('mysql:host='.$this->host.";dbname=information_schema;charset=UTF8;", $this->user, $this->password, [
                \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION
            ]);
        } catch(\PDOException $e) {
            return "ERROR :". $e->getMessage();
        }

        $this->bdd = $db;
    }
}
