<?php
namespace Geniusrw\Rhie\Model;

class Telecom {
    public $type;
    public $value;

    public function __construct($type, $value)
    {
        $this->type = $type;
        $this->value = $value;
    }
}