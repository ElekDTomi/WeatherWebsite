<?php 
$xml=simplexml_load_file("https://api.openweathermap.org/data/2.5/weather?id=785965&appid=545b1563d51e106eb6f284b4b1204d47&mode=xml&lang=hu&units=metric");

$jsonurl = file_get_contents('https://api.openweathermap.org/data/2.5/onecall?lat=45.9275&lon=20.0772&units=metric&mode=json&lang=hu&appid=a3a6e8f3dd3bbd3debaa600a7e2ac7ce');
$json = json_decode($jsonurl)
?>

<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <meta List="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap");
    </style>
    <title>Document</title>
  </head>
  <body>
    <link rel="stylesheet" href="index.css" />
    <div class="t-controlbar">
      <p class="t-welcomemsg"><?php 
      $date = date("H:i");
      if($date >= "00:00" && $date < "03:00"){
        echo "Jó éjszakát!";
      }else if($date >= "03:00" && $date < "09:00"){
        echo "Jó reggelt!";
      }else if($date >= "09:00" && $date < "19:00"){
        echo "Szép napot!";
      }else if($date >= "19:00" && $date < "22:00"){
        echo "Szép estét!";
      }else if($date >= "22:00" && $date < "23:59"){
        echo "Jó éjszakát!";
      }

      ?></p>
      <p class="t-time"></p>
    </div>
    <div class="t-weatherbox <?php 
    $wid = $xml->weather['number'];

      if($wid >= 200 && $wid <= 299){
        echo "t-thunderstormbg";
      }else if($wid >= 300 && $wid <= 399){
       echo "t-drizzlebg";
      }else if($wid >= 500 && $wid <= 599){
        echo "t-rainbg";
      }else if($wid >= 600 && $wid <= 699){
        echo "t-snowbg";
      }else if($wid == 800 ){
        if($date < "19:00" && $date > "6:00"){
          echo "t-sunbg";
        }else{
          echo "t-clearmoonbg";
        }
        
      }else if($wid >= 801 && $wid <= 899){
         if($date < "19:00" && $date > "6:00"){
          echo "t-cloudbg";
        }else{
          echo "t-cloudmoonbg";
        }
      }
    
    ?>">
    </div>
    <div class="t-weatherinfo">
      <p class="t-city"><?php echo$xml->city['name']?></p>
      <div class="t-temperaturecontainer">
        <p class="t-temperature"><?php $tv = round($xml->temperature['value'] - 0, 1); echo $tv ;
         ?>°C</p>




 <!--       <div class="t-minmax">
          <p class="t-mintemperature"><?php// $tmin = round($xml->temperature['min'] - 0); echo $tmin ;
         ?>°C</p>
          <p class="t-maxtemperature"><?php// $tmax = round($xml->temperature['max'] - 0); echo $tmax ;
         ?>°C</p>
        </div>-->
      </div>
            <p class="t-weathertxt"><?php echo $xml->weather['value'];  ?></p>
      <div class="t-etcinfo">
        <div class="t-humidity">
          <img class="t-humidityimg" src="icons/humidity.png" />
          <p class="t-humiditytext"><?php echo $xml->humidity['value'];?> %</p>
        </div>
        <div class="t-air-pressure">
          <img class="t-air-pressureimg" src="icons/barometer.png" />
          <p class="t-air-pressuretext"><?php echo $xml->pressure['value'];?> hPa</p>
        </div>
      </div>
      <div class="t-sunmoon">
      <div class="t-sun">
        <div class="t-sunrise">
          <img src="icons/sunrise.png" />
          <p><?php   echo date("H:i", strtotime($xml->city->sun['rise']) + 2*60*60 );  ?></p>
        </div>
        <div class="t-sunset">
          <img src="icons/sunset.png" />
          <p><?php   echo date("H:i", strtotime($xml->city->sun['set']) + 2*60*60 );  ?></p>
        </div>
      </div>
      <div class="t-moon">
        <div class="t-moonrise">
          <img src="icons/moonrise.png" />
          <p> <?php   echo date("H:i", $json->daily[0]->moonrise);  ?>
            </p>
        </div>
        <div class="t-moonset">
          <img src="icons/moonset.png" />
          <p><?php   echo date("H:i", $json->daily[0]->moonset);  ?></p>
        </div>
      </div>
</div>
    </div>

    <script>

      function addZero(x,n) {
    while (x.toString().length < n) {
      x = "0" + x;
    }
    return x;
  }
  
  function myFunction() {
    var d = new Date();
    var x = document.querySelector(".t-time");
    var mo = d.getMonth();
    var mo = mo + 1;
    var da = addZero(d.getDate(), 2);
    var h = addZero(d.getHours(), 2);
    var m = addZero(d.getMinutes(), 2);
    var s = addZero(d.getSeconds(), 2);
    x.innerHTML = mo + "/" + da + " " + h + ":" + m + ":" + s;
  }

  setInterval(myFunction, 1000);

    </script>
  </body>
</html>
