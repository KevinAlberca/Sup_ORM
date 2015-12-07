<?php

require_once("vendor/autoload.php");

$config = json_decode(file_get_contents(__DIR__."/config.json"));

# Declaration des objets qui vont nous servir
$generator = new Core\Generator();
if(isset($config) && !empty($config))
{
    $databaseChecker = new Core\DatabaseChecker($config->database_host, $config->database_name, $config->database_user, $config->database_password);
    $database = new Core\Database($config->database_host, $config->database_name, $config->database_user, $config->database_password);
}
else
{
    $databaseChecker = new Core\DatabaseChecker("127.0.0.1", "test_orm", "root", "root");
    $database = new Core\Database("127.0.0.1", "test_orm", "root", "root");
}


if(!isset($argv[1]) && empty($argv[1]))
{
    $argv[1] = "default";
}

# Un switch pour gerer les differents cas d'argument
switch($argv[1]) {

# Generer un ficher de configuration
    case "--config":
        if (!empty($argv[2]) && isset($argv[2], $argv[3], $argv[4], $argv[5])) {
            if ($generator::createConfigFile($argv[2], $argv[3], $argv[4], $argv[5])) {
                echo "\033[0;34m" . "Le fichier de configuration a bien été créé, il est disponible ici :\n" . __DIR__ . "/config.json";
            } else {
                echo "\033[1;31m" . "Le fichier de configuration n'a pas pu être créer";
            }
        } else {
            echo "\033[1;31m" . "Pour generer un fichier de configuration, merci d'utiliser la commande suivante :\nphp suporm --config DATABASE_HOST DATABASE_NAME DATABASE_USER DATABASE_PASSWORD";
        }
        break;

# Retourne l'etat de la connexion a la base de donnee
    case "database:exist":
        if (isset($argv[2]) || !empty($config))
        {
            $dbname = $argv[2] = $config->database_name;
            if($databaseChecker->checkIfExist($config->database_name) || $databaseChecker->checkIfExist($argv[2]) )
            {
                echo "\033[0;34m" . "La base de donnée ".$dbname." est existante";
            }
            else
            {
                echo "\033[1;31m" . "La base de donnée ".$dbname." est inexistante";
            }
        }
        else
        {
            echo "\033[1;31m" . "Merci d'utiliser la commande suivante :\nphp suporm database:exist DATABASE_HOST DATABASE_NAME DATABASE_USER DATABASE_PASSWORD";
        }
        break;

# Liste toutes les tables de la base de donnees + les donnees des tables
    case "database:list":
        if($databaseChecker->listTable())
        {
            $res = $databaseChecker->listTable();
            for ($i = 0; $i < count($res); $i++)
            {
                if ($res[$i]['TABLE_NAME'] !== @$res[$i - 1]['TABLE_NAME'])
                {
                    echo "\033[1;34m" . "|" . $res[$i]['TABLE_NAME'] . "\n";
                }
                echo "\033[1;32m" . "    | " . $res[$i]['COLUMN_NAME'] . " ( " . $res[$i]['DATA_TYPE'] . " )\n";
            }
        }
        else
        {
            echo "\033[0;31m"."La connexion a la base de donnee n'est pas possible\n";
        }
        break;

    case "create:table":
            if(isset($argv[2]) && !empty($argv[2]))
            {
                $fields= [];
                if($database->createTable($argv[2], $fields)){
                    echo "\033[1;32m"."OK";
                } else {
                    echo "\033[0;31m"."ERROR 1";
                }
            }
            else
            {
                echo "\033[0;31m"."Merci d'utiliser la commande suivante\nphp suporm create:table NOM_DE_TABLE";
            }
        break;
# Genere une table dans la base de donnee et genere une Entite
    case "delete:table":
            if(isset($argv[2]) && !empty($argv[2]))
            {
                if($database->deleteTable($argv[2])){
                    echo "\033[1;32m"."Successfull";
                } else{
                    echo ""."Error delete";
                }
            }
            else
            {
                echo "\033[0;31m"."Merci d'utiliser la commande suivante\nphp suporm delete:table NOM_DE_TABLE";
            }
        break;

# Le cas default pour gerer les options non reconnues
    default:
        echo "Liste des actions";
        break;
}

echo "\033[0;37m"."\n";

