<?php
namespace Geniusrw\Rhie;

use DateTime;
use Geniusrw\Rhie\Model\Address;
use Geniusrw\Rhie\Model\Contact;
use Geniusrw\Rhie\Model\Patient;
use Geniusrw\Rhie\Model\Identifier;
use Geniusrw\Rhie\Model\Telecom;
use Symfony\Component\HttpClient\HttpClient;

use function Geniusrw\Rhie\Support\config;

class HieClient {

    /***
     * @param $id
     * @param $type
     * return \Genius\Rhie\Model\Patient
     */
    public static function getUpid($id, $type){
        //Step 1 Ask Client Registry for the records
        $client = HttpClient::create(); 

        $response = $client->request(
            'GET',
            config('hie.url'). '/clientregistry/Patient?identifier=' . $id,
            [
                'auth_basic' => [config('hie.username'), config('hie.password')]
            ]
        );
        $patient = new Patient();

        $statusCode = $response->getStatusCode();
        if( $statusCode != 200){
            // No Data found
            $patient = static::checkUpid($id, $type);
        } else {
            $content = $response->toArray();
            // var_dump($content);
            if(array_key_exists("entry", $content) && count($content['entry']) > 0){
                $patient_data = $content['entry'][0];

                $patient->id = $patient_data['resource']['id'];

                if(array_key_exists("identifier", $patient_data['resource'])){
                    foreach($patient_data['resource']['identifier'] AS $identifier){
                        if(!array_key_exists("value", $identifier)){
                            continue;
                        }
                        $ident = new Identifier($identifier['system'], $identifier['value']);
                        $patient->identifiers[] = $ident;
                    }
                }

                if(array_key_exists("name", $patient_data['resource'])){
                    $patient->family_name = $patient_data['resource']['name'][0]['family'];
                    $patient->given_name = $patient_data['resource']['name'][0]['given'][0];
                }

                //Try parsing contacts
                if(array_key_exists("contact", $patient_data['resource'])){
                    foreach($patient_data['resource']['contact'] AS $contact){
                        //
                        if(!array_key_exists("given",$contact['name'] )){
                            continue;
                        }
                        $myContact = new Contact($contact['name']['family'], $contact['name']['given'][0], $contact['gender']);
                        $patient->contacts[] = $myContact;
                    }
                }

                // Handling Telecom
                if(array_key_exists("telecom", $patient_data['resource'])){
                    foreach($patient_data['resource']['telecom'] AS $telecom){
                        $patient->telecoms[] = new Telecom($telecom['system'], $telecom['value']);
                    }
                }

                //Handling Addresses
                if(array_key_exists("address", $patient_data['resource'])){
                    foreach($patient_data['resource']['address'] AS $address){
                        //
                        if(!array_key_exists("state", $address)){
                            $patient->addresses[] = new Address($address['country'], null, null, null, null, null);
                        } else {
                            $cell = count($address['line']) > 1?$address['line'][1]:"";
                            $village = count($address['line']) > 1?$address['line'][0]:"";
                            $patient->addresses[] = new Address($address['country'], $address['state'], $address['district'], $address['city'],$cell, $village);
                        }
                    }
                }
                $patient->gender = $patient_data['resource']['gender'];
                $patient->dob = $patient_data['resource']['birthDate'];
            } else {
                // No Data found
                $patient = static::checkUpid($id, $type);
            }
        }
        return $patient;
    }

    public static function checkUpid($value, $type){
        $client = HttpClient::create(); 

        $response = $client->request(
            'POST',
            config('hie.url'). '/api/v1/citizens/getCitizen',
            [
                'headers' => [
                    'Content-Type' => "application/json"
                ],
                'auth_basic' => [config("hie.username"), config("hie.password")],
                "body" => json_encode([
                    "fosaid" => "0022",
                    "documentType" => $type,
                    "documentNumber" => $value
                ])
            ]
        );
        $statusCode = $response->getStatusCode();
        // var_dump($statusCode);
        if($statusCode == 200) {
            $content = $response->toArray();
            // var_dump($content);
            if(count($content) == 3 && $content['status'] == "error"){
                return null;
            } else {
                // var_dump($content);
                $patient = new Patient();
                //Add ID
                $patient->id = $content['data']['documentNumber'];

                // Add Identifiers
                if(array_key_exists("upi", $content['data'])){
                    $patient->identifiers[] = new Identifier("UPI", $content['data']['upi']);
                }
                if(array_key_exists("applicationNumber", $content['data'])){
                    $patient->identifiers[] = new Identifier("NID_APPLICATION_NUMBER", $content['data']['applicationNumber']);
                }
                if(array_key_exists("nid", $content['data'])){
                    $patient->identifiers[] = new Identifier("NID", $content['data']['nid']);
                }

                //Add Names
                $patient->family_name = $content['data']['surName'];
                $patient->given_name = $content['data']['postNames'];

                // Adding Contact
                if(array_key_exists("fatherName", $content['data'])){
                    $patient->contacts[] = new Contact("FATHER NAME", $content['data']['fatherName'], "male");
                }
                if(array_key_exists("motherName", $content['data'])){
                    $patient->contacts[] = new Contact("MOTHER NAME", $content['data']['motherName'], "female");
                }
                if(array_key_exists("spouse", $content['data'])){
                    $patient->contacts[] = new Contact("SPOUSE NAME", $content['data']['spouse'], $content['data']['sex'] == "MALE"?"female":"male");
                }
                
                //No Telcome Available Here

                //Adding addresses
                $patient->addresses[] = new Address($content['data']['domicileCountry'], $content['data']['domicileProvince'], $content['data']['domicileDistrict'], $content['data']['domicileSector'], $content['data']['domicileCell'], $content['data']['domicileVillage']);

                //add gender
                $patient->gender = $content['data']['sex'];

                //Add Dob
                $patient->dob = (new \DateTime($content['data']['dateOfBirth']))->format("Y-m-d");
                return $patient;
            }
        }
    }
}