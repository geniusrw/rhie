<?php
namespace Genius\Rhie\Model;

class Address {
    public $country;
    public $province;
    public $district;
    public $sector;
    public $cell;
    public $village;

    public function __construct($country, $province, $district, $sector, $cell, $village)
    {
        $this->country = $country;
        $this->province = $province;
        $this->district = $district;
        $this->sector = $sector;
        $this->cell = $cell;
        $this->village = $village;
    }
}