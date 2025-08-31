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

** Supported Document Type **
* NID
* NID_APPLICATION
* UPI(stands for UPID)
