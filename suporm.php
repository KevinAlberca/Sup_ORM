<?php

require_once("vendor/autoload.php");


# Declaration des objets qui vont nous servir
$generator = new Core\Generator();


if(!isset($argv[1]) && empty($argv[1]))
{
    $argv[1] = "default";
}

# Un switch pour gerer les differents cas d'argument
switch($argv[1])
{

# Generer un ficher de configuration
    case "--config":
        if(!empty($argv[2]) && isset($argv[2], $argv[3], $argv[4], $argv[5]))
        {
            if($generator::createConfigFile($argv[2], $argv[3], $argv[4], $argv[5]))
            {
                echo "Le fichier de configuration a bien été créé, il est disponible ici :\n".__DIR__."/config.json";
            }
            else
            {
                echo "Le fichier de configuration n'a pas pu être créer";
            }
        }
        else
        {
            echo "Pour generer un fichier de configuration, merci d'utiliser la commande suivante :\nphp suporm --config DATABASE_HOST DATABASE_NAME DATABASE_USER DATABASE_PASSWORD";
        }
        break;
# Le cas default pour gerer les options non reconnues
    default:
        echo "Liste des actions";
        break;
}

echo "\n";

