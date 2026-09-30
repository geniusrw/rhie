<?php
require __DIR__.'/vendor/autoload.php';

use Geniusrw\Rhie\Rhip\RhipClient;

define("GENIUS_RHIE_BASE_PATH", __DIR__);

$patient = RhipClient::checkCbhiEligibity("1197070086995096");

var_dump($patient);