<?php

require __DIR__ . '/vendor/autoload.php';

use \CTApi\CTConfig;
use \CTApi\Requests\EventRequest;
use \CTApi\Requests\EventAgendaRequest;
use \CTApi\Models\File;
use \CTApi\Requests\SongRequest;

include './credentials.inc';

// Configuration
CTConfig::setApiUrl($url);
//authenticates the application and load the api-key into the config
try {
  CTConfig::authWithCredentials(
    $usr,
    $pwd
  );
} catch (Exception $e) {
  echo $e->getMessage();
  return;
}
// if everything works fine, the api-key is stored in your config
$apiKey = CTConfig::getApiKey();
// see documentation for further improvement: https://github.com/5pm-HDH/churchtools-api/blob/master/docs/CTConfig.md

// $events = EventRequest::where('from', date('Y-m-d', strtotime('-2months')))
//   ->where('to', date('Y-m-d', strtotime('+2months')))
//   ->orderBy('startDate')
//   ->get();
// $gds = [];

// foreach ($events as $event){
//   if ($event?->getCalendar()?->getDomainIdentifier() == "2"){
//     print($event->getName().' - '.$event->getStartDate().' - '.$event->getId().PHP_EOL);
//     $gds[] = $event;
//   }
// }

// get first gottesdienst in set
// $gd = $gds[0];

$gd = EventRequest::find(1908);
print($gd->getName() . ' - ' . $gd->getStartDate() . PHP_EOL);


$agenda = $gd?->requestAgenda();

// $eventItemsList = "";
// $eventSongsList = "";
// $agendaItems = ($agenda?->getItems() ?? []);
// foreach ($agendaItems as $item) {
//     $eventItemsList .= $item->getTitle() . " (" . $item->getType() . "), ";
//     $song = $item->getSong();
//     if (!is_null($song)) {
//         $eventSongsList .= $song->getName() . ", ";
//     }
// }


$songs = $agenda?->getSongs() ?? [];
// $songList = [];

foreach ($songs as $song) {
  print($song->getName() . ' (Key: ' . $song->getKey() . ')' . PHP_EOL);
  // $songList[] = intval($song->getId());
}

// var_dump($songList);

// foreach ($songList as $songId){
//   $song = SongRequest::findOrFail($songId);
//   var_dump($song);
// }
// $selectedArrangement = $song->requestSelectedArrangement();
// var_dump($selectedArrangement);
