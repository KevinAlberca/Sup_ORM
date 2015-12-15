<?php
/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 09/12/15
 * Time: 19:01
 */
require_once __DIR__."/../vendor/autoload.php";

$ORM = new ORM(); // Declaration de l'ORM
$user = new \Entity\Users(); // On instancie la classe Utilisateur

$clauses =  [
    "WHERE" => "name = 'Baptou'"
];


#################################################
#            SELECTIONNE DES DONNEES            #
#################################################

//var_dump($ORM->select($user, $clauses));

$user->setName("Baptou") // On lui mets un Nom
->setEmail("medrup@loscil.fr") // Email
->setPassword(sha1("DEBILE")) // Password
->setInscription_date(date("Y-m-d H:i:s")); // Inscription


############################################
#            INSERT DES DONNEES            #
############################################
/*
if($ORM->save($user))
{
  echo "OK";
}
else
{
  echo "FAILED";
}
*/
#################################################
#            MISE A JOUR DES DONNEES            #
#################################################

$user->setName("Baptiste") // On lui mets un Nom
->setEmail("test@orm.dev") // Email
->setPassword(sha1("Sup_ORM")) // Password
->setInscription_date(date("Y-m-d H:i:s")); // Inscription

/*
if($ORM->update($user, $clauses))
{
    echo "Mise a jour effectuee";
}
else
{
    echo "Mise a jour echouee";
}
*/


##############################################
#            SUPPRIME DES DONNEES            #
##############################################
if($ORM->delete($user, $clauses))
{
  echo "Data supprimee avec succes";
}
else
{
  echo "Data non supprimee";
}