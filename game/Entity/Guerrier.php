<?php
namespace Entity;

use \Entity\Personnage;

class Guerrier extends Personnage {

     public function __construct($name = ""){
     	parent::__construct($name);
	    $this->setStrength($this->getStrength() + 10);
	    echo "Rooooooar !\n";
     }


	public function attack(\Core\CanFightInterface $target){
		if($target->isAlive()){
			echo $this->getName(). " (".$this->getHp().") attacks ".$target->getName()." (".$target->getHp().")\n";
			echo $this->getName(). " hits ".$this->getStrength()." damage to ".$target->getName()."\n";
			$target->takeDamage($this->getStrength());
		} else {
			echo $target->getName()." is already dead !\n";
		}
	}

}
