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

    public static function createEntity($name, Array $fields)
    {
        $name = ucfirst(strtolower($name));
        $entity = "<?php \n\nnamespace Entity; \n\nclass ".$name."\n{\n";
        foreach ($fields as $field => $f)
        {
            $f['name'] = str_replace(" ", "_", $f['name']);
            $entity .= "\n    /**\n     * @var ".$f['type']."\n    **/\n    private $".strtolower($f['name']).";\n";
        }
        $entity .= "\n    public function __construct()\n    {\n    \n    }";

        foreach ($fields as $field => $f)
        {
            $f['name'] = str_replace(" ", "_", $f['name']);
            $entity .= "\n    public function set".ucfirst(strtolower($f['name']))."($".strtolower($f['name']).")\n    {\n        $"."this->".strtolower($f['name'])." = $".strtolower($f['name']).";\n    }\n";
            $entity .= "\n    public function get".ucfirst(strtolower($f['name']))."()\n    {\n        return $"."this->".strtolower($f['name']).";\n    }\n";
        }

        $entity .= "\n}";


        if(file_put_contents(__DIR__."/../../Entity/".$name.".php", $entity))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}