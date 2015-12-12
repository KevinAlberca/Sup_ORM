<?php
/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 09/12/15
 * Time: 19:01
 */

error_reporting(E_ALL);


require_once __DIR__."/../vendor/autoload.php";

$ORM = new ORM(); // Declaration de l'ORM
$user = new \Entity\Users(); // On instancie la classe Utilisateur

$user->setName("Baptiste") // On lui mets un Nom
    ->setEmail("medrup@loscil.fr") // Email
    ->setPassword(sha1("JeSuisMauvais123")) // Password
    ->setInscription_date(date("Y-m-d H:i:s")) // Inscription
    ->setLast_connexion(date("Y-m-d H:i:s")); // Derniere Connexion

//if($ORM->save($user)){
//    echo "DATA INSEREE"; //Si il n'y a aucun probleme on retourne ce message
//    echo "<ul>
//<li>".$user->getName()."</li>
//<li>".$user->getEmail()."</li>
//<li>".$user->getPassword()."</li>
//<li>".$user->getInscription_date()."</li>
//<li>".$user->getLast_connexion()."</li></ul>";

//} else {
//    echo "ERROR"; // Sinon, on retourne une erreur
//}

var_dump($ORM->update($user, [
    "WHERE" => "id = 1",
]));