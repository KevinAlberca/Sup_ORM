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
}