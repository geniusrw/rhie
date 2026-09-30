<?php
namespace Geniusrw\Rhie\Model;

class Patient {
    public $id;
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
    public $registered_on;

    public function patientToFhir(){
        $address = [];
        if(is_array($this->addresses) && count($this->addresses) > 0){
            $address["line"] = [
                $this->addresses[0]->cell,
                $this->addresses[0]->village
            ];
            $address["city"] = $this->addresses[0]->sector;
            $address["district"] = $this->addresses[0]->district;

            if(!is_null($this->addresses[0]->province)){
                $address["state"] = $this->addresses[0]->province;
            }

            if(!is_null($this->addresses[0]->province)){
                $address["country"] = $this->addresses[0]->country;
            }
        }

        $data = [
            "resourceType" => "Patient",
            "id" => $this->id,
            "identifier" => $this->identifiers,
            "name" => [
                "family" => $this->family_name,
                "given" => [
                    $this->given_name,
                ]
            ],
            "telecom" => [
                [
                    "system" => strtolower($this->telecoms[0]->system),
                    "value" => $this->telecoms[0]->value
                ]
            ],
            "gender" => strtolower($this->gender),
            "birthDate" => $this->dob,
            "address" => [$address],
            "contact" => [
                [
                    "name" => [
                        "family" => $this->contacts[0]->type,
                        "given" => [
                            $this->contacts[0]->name
                        ],
                        "gender" => $this->contacts[0]->gender
                    ],
                ],
                [
                    "name" => [
                        "family" => $this->contacts[1]->type,
                        "given" => [
                            $this->contacts[1]->name
                        ],
                        "gender" => $this->contacts[1]->gender
                    ],
                ]
            ]
        ];

        return $data;
    }
}