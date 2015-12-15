<?php 

namespace Entity; 
use \Core\Builder;

class Users
{

    /**
     * @var int
    **/
    private $id;

    /**
     * @var varchar
    **/
    public $name;

    /**
     * @var varchar
    **/
    public $password;

    /**
     * @var varchar
    **/
    public $email;

    /**
     * @var datetime
    **/
    public $inscription_date;

    /**
     * @var datetime
    **/
    public $last_connexion;

    public function __construct()
    {
        $QB = new Builder();
        return $QB->hydrateEntity($this);
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;    
    }

    public function getId()
    {
        return $this->id;
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

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;    
    }

    public function getEmail()
    {
        return $this->email;
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

    public function setLast_connexion($last_connexion)
    {
        $this->last_connexion = $last_connexion;
        return $this;    
    }

    public function getLast_connexion()
    {
        return $this->last_connexion;
    }

}