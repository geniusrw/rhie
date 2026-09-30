<?php
namespace Geniusrw\Rhie\Model;

class Identifier {
    public $system;
    public $value;

    public function __construct($type, $value)
    {
        $this->system = $type;
        $this->value = $value;
    }

    public function getType(){
        return $this->system;
    }

    public function getValue(){
        return $this->value;
    }
}