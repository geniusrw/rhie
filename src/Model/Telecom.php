<?php
namespace Geniusrw\Rhie\Model;

class Telecom {
    public $system;
    public $value;

    public function __construct($system, $value)
    {
        $this->system = $system;
        $this->value = $value;
    }
}