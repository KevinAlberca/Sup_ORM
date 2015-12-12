<?php

namespace Entity;

use \Core\CanFightInterface;

class Rabbit  implements CanFightInterface {

	private $alive;

	public function __construct(){
		$this->alive = true;
	}

	public function attack(CanFightInterface $target){
		$target->takeDamage(1);
	}

	public function takeDamage($damage){
		if($this->isAlive()){
			echo "A Rabbit died !\n";
		}
	}

	public function getName(){
		return "Rabbit";
	}

	public function getHp(){

	}

	public function isAlive(){
		return $this->alive;
	}
}
