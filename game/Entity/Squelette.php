<?php
namespace Entity;


use Entity\Monster;

class Squelette extends Monster
{
    public $name;
    public $damage;
    public $HP;

    public function __construct($name){
        parent::__construct($name);
        $this->setName($name);
        $this->setHP(100);
        echo $this->getName($name)." is born\n";
    }

    public function attack(\Core\CanFightInterface $target){
        $this->setDamage(15);
        echo $this->getName()." attaque et inflige ".$this->getDamage(). " dommages a ".$target->getName()."(".$target->getHp().")\n";
        $target->takeDamage($this->getDamage());
    }

    public function takeDamage($damage){
        $this->setHP($this->getHP() - $damage);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDamage()
    {
        return $this->damage;
    }

    public function setDamage($damage)
    {
        $this->damage = $damage;
    }


    public function getHP()
    {
        return $this->HP;
    }

    public function setHP($HP)
    {
        $this->HP = $HP;
    }


    public function isAlive(){
        return $this->getHp() > 0;
    }
}
