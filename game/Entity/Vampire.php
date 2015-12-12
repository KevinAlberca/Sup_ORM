<?php
namespace Entity;

use Entity\Monster;

class Vampire extends Monster
{
    public $name;
    public $HP;
    public $strenght;
    public $damage;


    public function __construct($name){
        parent::__construct($name);
        $this->setName($name);
        $this->setHP(100);
        echo $this->getName($name)." is born\n";
    }

    public function attack(\Core\CanFightInterface $target){
        $this->setDamage(mt_rand(5, 15));
        echo $this->getName()." attaque et inflige ".$this->getDamage(). " dommages a ".$target->getName()."(".$target->getHp().")\n";
        $target->takeDamage($this->getDamage());
    }

    public function takeDamage($damage){
        $this->setHP($this->getHP() - $damage);
        if($this->getHP() <= 0){
            echo $this->getName()." died. . .\n";
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getHP()
    {
        return $this->HP;
    }

    public function setHP($HP)
    {
        $this->HP = $HP;
    }

    public function getStrenght()
    {
        return $this->strenght;
    }

    public function setStrenght($strenght)
    {
        $this->strenght = $strenght;
    }

    public function getDamage()
    {
        return $this->damage;
    }

    public function setDamage($damage)
    {
        $this->damage = $damage * intval(mt_rand(1,10)/3.33);
    }


    public function isAlive(){
        return $this->getHp() > 0;
    }



}
