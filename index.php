<?php

require __DIR__ . '/vendor/autoload.php';

// Use churchtools api wrapper from:
// https://github.com/5pm-HDH/churchtools-api

// probably a bit dated...
// https://github.com/vineyardkoeln/churchtools-api

use \CTApi\CTConfig;

//set the url of your churchtools application api
//important! ApiUrl must end with Top-Level-Domain. No paths allowed!
CTConfig::setApiUrl("https://rebgarten.church.tools");

include './credentials.inc';

//authenticates the application and load the api-key into the config
try {
  CTConfig::authWithCredentials(
    $usr,
    $pwd
  );
} catch ( Exception $e){
  echo $e->getMessage();
  return;
}


// if everything works fine, the api-key is stored in your config
$apiKey = CTConfig::getApiKey();

print_r($apiKey);
