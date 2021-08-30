<?php 

require_once __DIR__ . '/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

$xml=simplexml_load_file("https://api.openweathermap.org/data/2.5/weather?id=785965&appid=545b1563d51e106eb6f284b4b1204d47&mode=xml&lang=hu&units=metric");

$jsonurl = file_get_contents('https://api.openweathermap.org/data/2.5/onecall?lat=45.9275&lon=20.0772&units=metric&mode=json&lang=hu&appid=a3a6e8f3dd3bbd3debaa600a7e2ac7ce');
$json = json_decode($jsonurl);


      $date = date("H:i");

      switch ($date){
        case $date >= "00:00" && $date < "03:00";
          $welcomemsg = "Jó éjszakát!";
          break;
        case $date >= "03:00" && $date < "09:00";
          $welcomemsg =  "Jó reggelt!";
          break;
        case $date >= "09:00" && $date < "19:00";
          $welcomemsg =  "Szép napot!";
          break;
        case $date >= "19:00" && $date < "22:00";
          $welcomemsg =  "Szép estét!";
          break;
        case $date >= "22:00" && $date < "23:59";
          $welcomemsg =  "Jó éjszakát!";
          break;
      }

      
    $wid = $xml->weather['number'];


      switch ($wid){
        case $wid >= 200 && $wid <= 299;
          $wbg =  "t-thunderstormbg";
          break;
        case $wid >= 300 && $wid <= 399;
          $wbg = "t-drizzlebg";
          break;
        case $wid >= 500 && $wid <= 599;
          $wbg = "t-rainbg";
          break;
        case $wid >= 600 && $wid <= 699;
          $wbg = "t-snowbg";
          break;
        case $wid == 800;
              if($date >= "06:00" && $date <= "19:00"){
                $wbg = "t-sunbg";
              }else{
                $wbg = "t-clearmoonbg";
              }
          break;
        case $wid >= 801 && $wid <= 899;
            
              if($date >= "06:00" && $date <= "19:00"){
                $wbg = "t-cloudbg";
              }else{           
                $wbg = "t-cloudmoonbg";
              }
          break;
      }

echo $twig->render('template.html', [
    'welcomemsg' => $welcomemsg,
    'wbg' => $wbg,
    'city' => $xml->city['name'],
    'temp' => round($xml->temperature['value'] - 0, 1),
    'tempmin' => round($xml->temperature['min'] - 0),
    'tempmax' => round($xml->temperature['max'] - 0),
    'wtext' => $xml->weather['value'],
    'humidity' => $xml->humidity['value'],
    'pressure' => $xml->pressure['value'],
    'sunrise' => date("H:i", strtotime($xml->city->sun['rise']) + 2*60*60 ),
    'sunset' => date("H:i", strtotime($xml->city->sun['set']) + 2*60*60 ),
    'moonrise' => date("H:i", $json->daily[0]->moonrise),
    'moonset' => date("H:i", $json->daily[0]->moonset)

]);



?>