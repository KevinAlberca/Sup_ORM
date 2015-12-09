<?php
/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 07/12/15
 * Time: 09:06
 */

namespace Core;


class Connexion
{

    static $db;

    public static function getConnexion($host, $dbname, $user, $password)
    {
        $database = null;
        try {
            $database = new \PDO('mysql:host='.$host.";dbname=".$dbname.";charset=UTF8;", $user, $password, [
                \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION
            ]);
        } catch(\PDOException $e) {
            return "ERROR :". $e->getMessage();
        }

        self::$db = $database;
        return self::$db;
    }

}