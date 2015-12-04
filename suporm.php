<?php


if(!isset($argv[1]) && empty($argv[1]))
{
    $argv[1] = "default";
}

# Un switch pour gerer les differents cas d'argument
switch($argv[1])
{
# Le cas default pour gerer les options non reconnues
    default:
        echo "Liste des actions";
        break;
}

echo "\n";

