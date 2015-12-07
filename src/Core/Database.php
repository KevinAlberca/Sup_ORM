<?php

namespace Core;

class Database
{
    private $bdd;

    public function __construct($host, $dbname, $dbuser, $dbpass)
    {
        $this->bdd = Connexion::getConnexion($host, $dbname, $dbuser, $dbpass);
    }

    public function set()
    {

    }

    public function hydrate(Object $object)
    {

    }

}