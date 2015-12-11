<?php 

namespace Entity; 

class Testing_before_coding
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
    public $description;

    /**
     * @var datetime
    **/
    public $date;

    public function __construct()
    {
    
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

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;    
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDate($date)
    {
        $this->date = $date;
        return $this;    
    }

    public function getDate()
    {
        return $this->date;
    }

}