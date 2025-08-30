<?php
namespace Genius\Rhie\Model;

class Patient {
    public array $contacts = [];
    public array $addresses = [];
    public array $identifiers = [];
    public array $telecoms = [];

    public $family_name;
    public $given_name;
    public $gender;
    public $dob;

    public $religion;
    public $ocupation;
}