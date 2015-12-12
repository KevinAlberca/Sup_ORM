<pre>
<?php

require_once("autoload.php");

use Entity\Mage;
use Entity\Guerrier;
use Entity\Rabbit;
use Entity\Vampire;
use Entity\Squelette;
use Core\CharacterCreationException;

try {
  $m = new Mage("Mage");
  $g = new Guerrier("Guerrier");
  // Under this line, we generate an error
  //$test = new Mage("");
} catch (CharacterCreationException $e){
  die("Character creation error : ".$e->getMessage()." in ".$e->getClassName()."\n");
} catch (\Exception $e){
  die($e->getMessage()."\n");
}



$r1 = new Rabbit();
$r2 = new Rabbit();
$r3 = new Rabbit();

while ($m->isAlive() && $g->isAlive()){
    $m->attack($g);
    $g->attack($m);
}


echo "<hr />";


$vampire = new Vampire("Vampire");
$squelette = new Squelette("Squelette");


while ($vampire->isAlive() && $squelette->isAlive()){
    $vampire->attack($squelette);
    $squelette->attack($vampire);
}
