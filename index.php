<?php

require __DIR__ . '/vendor/autoload.php';

// Use churchtools api wrapper from:
// https://github.com/5pm-HDH/churchtools-api

// probably a bit dated...
// https://github.com/vineyardkoeln/churchtools-api

use \CTApi\CTConfig;
use \CTApi\Requests\EventRequest;
use \CTApi\Requests\EventAgendaRequest;
include './credentials.inc';

//set the url of your churchtools application api
//important! ApiUrl must end with Top-Level-Domain. No paths allowed!
CTConfig::setApiUrl("https://rebgarten.church.tools");

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

// Retrieve all events from now
$events = EventRequest::where('from', date('Y-m-d', strtotime('today')))
  ->where('to', date('Y-m-d', strtotime('+2months')))
  ->orderBy('startDate')
  ->get();

foreach ($events as $event){
  $event = EventRequest::find($event->getId());
  $eventServices = $event?->getEventServices() ?? [];
  $speakers = [];
  foreach ($eventServices as $eventService) {
    if ($eventService?->requestService()?->getId() == 1) {
      if ($eventService?->getName()){
        $speakers[] = $eventService?->getName();
      }
    }
  }

  $title = "(" . $event?->getId() . ") ";
  $title .= $event?->getName();
  $title .= empty($speakers) ? '' : ' mit ' . join(', ', $speakers);
  echo $title, "\n";
  // echo $event->getDescription(), "\n";
  echo $event?->getStartDate(), " - ", $event?->getEndDate(), "\n";
  echo 'Kalender: ', $event?->getCalendar()->getTitle(), "\n";
  // echo "uuid: ", $event->getGuid(), "\n";
  echo "\n";
  // $agenda = $event?->requestAgenda();
}
