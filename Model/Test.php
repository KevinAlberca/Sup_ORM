<?php 

namespace Model; 

class Test extends
{

    /**
     * @var tinyint(1)
    **/
    private $debug;

    /**
     * @var varchar(255)
    **/
    private $name;

    /**
     * @var varchar(255)
    **/
    private $password;

    /**
     * @var datetime
    **/
    private $inscription;

    public function __construct()
    {
    
    }
    public function setDebug($debug)
    {
        $this->debug = $debug;
        return $this;
    }

    public function getDebug()
    {
        return $this->debug;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setInscription($inscription)
    {
        $this->inscription = $inscription;
        return $this;
    }

    public function getInscription()
    {
        return $this->inscription;
    }

}