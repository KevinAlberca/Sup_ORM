<?php
namespace Entity;

use \Core\CanFightInterface;

abstract class Monster implements \Core\CanFightInterface
{

    public $name;

    public function __construct($name){
        $this->name = $name;
    }

    public function takeDamage($damage){

    }

    public function getName(){

    }

    public function getHp(){

    }

    public function isAlive(){
        return $this->getHp() > 0;
    }



}
