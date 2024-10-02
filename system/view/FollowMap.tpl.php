
<?php
/*NAPOMENA

KORISTENI KODOVI SA 
https://leafletjs.com/examples/accessibility/#markers-must-be-labelled
https://www.w3schools.com/js/js_loop_for.asp,
https://leafletjs.com/examples/quick-start/,
https://www.php.net/manual/en/function.http-response-code.php

 */
$statusCode=http_response_code();
if($statusCode==200){
echo "<script>var data = '$data';</script>";
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
      <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>



<style>
body {
  background-color: linen;
}


#map { height: 380px;
        margin:10px;
        border:1px solid black;
}

</style>
</head>
<body>


<div id="map"></div>


 
</div>

<script>
    const rez=JSON.parse(data);
    var roadTrip=[];
    var map = L.map('map').setView([rez[1]['latituda'], rez[1]['longituda']], 5);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);


for(let i=0; i<rez.length; i++)
{
    var marker = L.marker([rez[i]['latituda'], rez[i]['longituda']],{alt: 'Flight: '}).addTo(map) 
  .bindPopup(rez[i]['flight']+": :"+ rez[i]['time']);

  roadTrip.push([rez[i]['latituda'], rez[i]['longituda']]);
}
/*
var latlngs = [
    [rez[0]['latituda'], rez[0]['longituda']],
    [rez[1]['latituda'], rez[1]['longituda']],
    [34.04, -118.2]
];
*/
var polyline = L.polyline(roadTrip, {color: 'red',weight:10}).addTo(map);

// zoom the map to the polyline
map.fitBounds(polyline.getBounds());

//nemoj zabroavi ode ti je za provjeru podataka ostalo



</script>

</body>
</html> <?php }

else
{

}
?>