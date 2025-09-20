# RHIE Integration with PHP application (Compatible with Laravel)

## Installation
Run the following command to install the package using composer\
`composer require geniusrw/rhie`\
or download the [zip](https://github.com/geniusrw/rhie/releases/latest) from github

## Setup the package

### Setting required configuration

1. Configuration information
Make sure to have the config folder in your root project\
Copy the hie.php.example file name it to hie.php into you config folder

2. Environment information
Rename .env.example file to .env file and change required values to match you setup

3. Using the package to get Patient's UPID

```
<?php
require_once "vendor/autoload.php";
use Geniusrw\Rhie\HieClient;

$patient = HieClient::getUpid("xxxxxxxxxxxxxxxx", "NID");
```
The above code will return the Patient RhiePatient Object or null when the identifier is not found

**Supported Document Type**
* NID
* NID_APPLICATION
* UPI(stands for UPID)

### Requesting Insurance Portal Information

1. Make sure the .env file hold required params

```
RHIP_URL=URL_PREFIX
RHIP_KEY=APP_KEY
RHIP_ORIGIN=APP_ORIGIN
```
Those parameters should be marched with real values shared from RHIP Team.

2. Check for CBHI Elibility

```
<?php

require_once "vendor/autoload.php";

use Geniusrw\Rhie\Rhip\RhipClient;

define("GENIUS_RHIE_BASE_PATH", __DIR__);

$patient = RhipClient::checkCbhiEligibity("xxxxxxxxxxxxxxxx");
```