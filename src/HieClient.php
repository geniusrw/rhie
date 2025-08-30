<?php
namespace Genius\Rhie;

use Genius\Rhie\Model\Patient;
class HieClient {

    /***
     * @param $id
     * @param $type
     * return \Genius\Rhie\Model\Patient
     */
    public static function getUpid($id, $type){
        //
        $patient = new Patient();
        return $patient;
    }
}