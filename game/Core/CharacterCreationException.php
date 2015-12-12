<?php

namespace Core;


class CharacterCreationException extends \Exception {
  private $className;

  public function getClassName(){
    return $this->className;
  }

  public function setClassName($className){
    $this->className = $className;
  }

}