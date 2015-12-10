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
            file_put_contents(__DIR__."/../../error.log", "[".\date("d-m-Y H:i:s")."]".$e->getCode()." : ".$e->getMessage()."\n", FILE_APPEND);
            return false;
        }

        self::$db = $database;
        return self::$db;
    }

}