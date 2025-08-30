<?php
namespace Genius\Rhie\Model;

class Telecom {
    public $type;
    public $value;

    public function __construct($type, $value)
    {
        $this->type = $type;
        $this->value = $value;
    }
}