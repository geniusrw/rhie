<?php
require __DIR__.'/vendor/autoload.php';

use Geniusrw\Rhie\HieClient;
use Geniusrw\Rhie\Model\Patient;
use Geniusrw\Rhie\Model\Address;
use Geniusrw\Rhie\Model\Contact;
use Geniusrw\Rhie\Model\Identifier;
use Geniusrw\Rhie\Model\Telecom;

$patient = new Patient();

$patient->id = "260111-0605-1717";
$patient->family_name = "UWINGABIRE";
$patient->given_name = "Beatrice";
$patient->gender = "Female";
$patient->dob = "1988-01-01";
$patient->registered_on = "2026-02-14";
$patient->addresses[] = new Address("Rwanda", "South", "Gisagara", "Save", "Rwanza", "Akarambo");
$patient->contacts[] = new Contact("Father Name", "GRATIEN HABARUREMA", "Male");
$patient->contacts[] = new Contact("Mother Name", "ASSOUMPTA MUKAMUKWIYE", "Female");
$patient->identifiers[] = new Identifier("NID", "1198870116388046");
$patient->identifiers[] = new Identifier("UPI", "260111-0605-1717");
$patient->telecoms[] = new Telecom("phone", "0783089997");

$dataSent = HieClient::sendToCR($patient->patientToFhir());

var_dump($dataSent);