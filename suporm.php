<?php

require_once("vendor/autoload.php");

if(file_exists(__DIR__."/config.json"))
{
    $config = json_decode(file_get_contents(__DIR__."/config.json"));
}

# Declaration des objets qui vont nous servir
if(!empty($config))
{
    $databaseChecker = new Core\DatabaseChecker($config->database_host, $config->database_name, $config->database_user, $config->database_password);
    $database = new Core\Database($config->database_host, $config->database_name, $config->database_user, $config->database_password);
}
elseif(!empty($argv[2] && $argv[3] && $argv[4] && $argv[5]))
{
    $databaseChecker = new Core\DatabaseChecker($argv[2], $argv[3], $argv[4], $argv[5]);
    $database = new Core\Database($argv[2], $argv[3], $argv[4], $argv[5]);
}
else
{
    echo "Merci de preciser a chaque commande vos identifiants a la base de donnees\nphp suporm.php {{ACTION}} DBHOST DBNAME DBUSER DBPASS\n";
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
            if (\Core\Generator::createConfigFile($argv[2], $argv[3], $argv[4], $argv[5])) {
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
        if (!empty($config))
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
        if($databaseChecker->listAllTables())
        {
            $res = $databaseChecker->listAllTables();
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
            if(!empty($argv[2]))
            {
                $fields= [];
                if($database->createTable($argv[2], $fields)){
                    echo "\033[1;32m"."La Table a ete creee dans la base de donnee.\nL'Entity est disponible a cet endroit :\n".__DIR__."/src/Entity/".$argv[2].".php";
                } else {
		  echo "\033[0;31m"."La table n'a pas pu etre creee";
                }
            }
            else
            {
                echo "\033[0;31m"."Merci d'utiliser la commande suivante\nphp suporm create:table NOM_DE_TABLE";
            }
        break;
# Genere une table dans la base de donnee et genere une Entite
    case "delete:table":
        if(!empty($argv[2]))
        {
            if($database->deleteTable($argv[2])){
                echo "\033[1;32m"."La suppression de la table a bien ete realisee.";
            } else{
                echo "\033[0:31m"."La supression de la table n'a pas pu etre faite.";
            }
        }
        else
        {
            echo "\033[0;31m"."Merci d'utiliser la commande suivante\nphp suporm delete:table NOM_DE_TABLE";
        }
        break;
###################
#    Generator    #
###################

# Genere la classe Entity sans obligatoirement creer une table
    case "generate:entity":
        if(!empty($config) || !empty($argv[6]))
        {
            $data = [];
            foreach($databaseChecker->listThisTable($argv[6]) as $database => $table){
                $data[] = [
                    'name' => $table['COLUMN_NAME'],
                    'type' => $table['DATA_TYPE'],
                ];
            }

            if(\Core\Generator::createEntity($argv[6], $data))
            {
                echo "\033[1;32m"."L'entitee a bien ete generee";
            }
            else
            {
                echo "\033[0;31m"."L'entitee n'a pas pu etre generee ! ";
            }
        }
        else
        {
            echo "\033[0;31m"."Merci d'utiliser la commande suivante :\nphp suporm.php generate:entity DATABASE_HOST DATABASE_NAME DATABASE_USER DATABASE_PASSWORD TABLE_NAME";
        }

        break;

# Le cas default pour gerer les options non reconnues
    default:
        echo "\033[1;35m"."Liste des actions".
            "\n\033[0;34m"."x --config -> Creer le fichier de configuration".
            "\n\033[1;36m"."x database:exist -> Verifie si la base de donnee est existante".
            "\n\033[0;36m"."x database:list -> Liste les tables de la base de donnee".
            "\n\033[1;36m"."x create:table -> Creer le fichier de configuration".
            "\n\033[0;36m"."x --config -> Creer le fichier de configuration".
            "\n\033[1;36m"."x delete:table -> Creer le fichier de configuration";
        break;
}

echo "\033[0;37m"."\n";

