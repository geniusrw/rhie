<?php
namespace Genius\Rhie\Model;

class Contact {
    public $type;
    public $name;
    public $gender;

    public function __construct($type, $name, $gender)
    {
        $this->type = $type;
        $this->name = $name;
        $this->gender = $gender;
    }
}