<?php 

namespace Model;
use Core\Querys;


class Users extends Querys
{

    /**
     * @var varchar(255)
    **/
    private $name;

    /**
     * @var varchar(255)
    **/
    private $password;

    /**
     * @var varchar(255)
    **/
    private $e_mail;

    /**
     * @var datetime
    **/
    private $inscription_date;

    /**
     * @var tinyint(1)
    **/
    private $banned;

    public function __construct()
    {
    
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

    public function setE_mail($e_mail)
    {
        $this->e_mail = $e_mail;
        return $this;
    }

    public function getE_mail()
    {
        return $this->e_mail;
    }

    public function setInscription_date($inscription_date)
    {
        $this->inscription_date = $inscription_date;
        return $this;
    }

    public function getInscription_date()
    {
        return $this->inscription_date;
    }

    public function setBanned($banned)
    {
        $this->banned = $banned;
        return $this;
    }

    public function getBanned()
    {
        return $this->banned;
    }

}