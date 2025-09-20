<?php
namespace Geniusrw\Rhie\Rhip;

use DateTime;

use Symfony\Component\HttpClient\HttpClient;

use function Geniusrw\Rhie\Support\config;


class RhipClient {

	public static function checkCbhiEligibity($id){
		$client = HttpClient::create(); 

        $response = $client->request(
            'GET',
            config('hie.rhip.url'). '/' . $id."/cbhi",
            [
            	'headers' => [
            		'Content-Type' => 'application/json',
            		'x-api-key' => config('hie.rhip.key'),
            		'origin' => config('hie.rhip.origin')
            	],
            ]
        );

        if($response->getStatusCode() != 200){
        	//Here create the invalid response

        	$data = [
        		"success" => false,
        		"message" => "Household is not found",
        		"status" => "NOT ELIGIBLE"
        	];
        } else {
        	$data = $response->toArray();
        }

		return $data;
	}

}