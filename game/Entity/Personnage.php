<?php

namespace Entity;

use Core\CanFightInterface;
use Core\CharacterCreationException;

abstract class Personnage implements CanFightInterface {

	private $name;
	private $hp;
	private $mana;
	private $strength;
	private $intelligence;
	private $agility;
	private $xp;
	private $level;

	public function __construct($name = ""){
	  if($name == ""){
	    $e = new CharacterCreationException("Name is empty");
	    $e->setClassName(get_class($this));
	    throw $e;
	  }
		$this->setName($name);
		$this->setHp(100);
		$this->setMana(200);
		$this->setStrength(10);
		$this->setIntelligence(10);
		$this->setAgility(10);
		$this->setXp(0);
		$this->setLevel(1);
		echo $this->getName()." is born !\n";
	}

	public function isAlive(){
		return $this->getHP() > 0;
	}


	public function takeDamage($damage){
		$this->setHp($this->getHp() - $damage);
		if($this->getHp() <= 0){
			echo $this->getName()." died. . .\n";
		}
	}

	public function setName($name){
		$name = ucfirst(strtolower($name));
		$this->name = $name;
	}

	public function getName(){
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getHP(){
		return $this->hp;
	}

	/**
	 * @param mixed $hp
	 */
	public function setHP($hp){
		$this->hp = $hp;
	}

	/**
	 * @return mixed
	 */
	public function getMana(){
		return $this->mana;
	}

	/**
	 * @param mixed $mana
	 */
	public function setMana($mana){
		$this->mana = $mana;
	}

	/**
	 * @return mixed
	 */
	public function getStrength(){
		return $this->strength;
	}

	/**
	 * @param mixed $strength
	 */
	public function setStrength($strength){
		$this->strength = $strength;
	}

	/**
	 * @return mixed
	 */
	public function getIntelligence(){
		return $this->intelligence;
	}

	/**
	 * @param mixed $intelligence
	 */
	public function setIntelligence($intelligence){
		$this->intelligence = $intelligence;
	}

	/**
	 * @return mixed
	 */
	public function getAgility(){
		return $this->agility;
	}

	/**
	 * @param mixed $agility
	 */
	public function setAgility($agility){
		$this->agility = $agility;
	}

	/**
	 * @return mixed
	 */
	public function getXp(){
		return $this->xp;
	}

	/**
	 * @param mixed $xp
	 */
	public function setXp($xp){
		$this->xp = $xp;
	}

	/**
	 * @return mixed
	 */
	public function getLevel(){
		return $this->level;
	}

	/**
	 * @param mixed $level
	 */
	public function setLevel($level){
		$this->level = $level;
	}

}
