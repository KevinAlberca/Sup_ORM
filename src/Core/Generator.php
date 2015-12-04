<?php

namespace Core;

class Generator
{
    public static function createConfigFile($host, $dbname, $dbuser, $dbpass)
    {
        $config = [
            "database_host" => $host,
            "database_name" => $dbname,
            "database_user" => $dbuser,
            "database_password" => $dbpass,
        ];

        if(file_put_contents(__DIR__."/../../config.json", json_encode($config)))
        {
            return true;
        }
        else
        {
            return false;
        }

    }
}