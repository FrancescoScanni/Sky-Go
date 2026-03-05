<?php
$band = intval($_GET['band']);
$file = 'band.json';

$jsonEfile = file_get_contents($file);
$dati = json_decode($jsonEfile, false); 
$bands = $dati->bands; 

foreach ($bands as $single_band) { 
  if($single_band->id == $band){  

    echo "Album: <b>".$single_band->album->title."</b><br>";
    echo "Anno uscita: <b>".$single_band->album->year."</b><br>";
    echo "Tracce:"."<br><br>";

    foreach ($single_band->album->tracks as $track){
        echo "<i>".$track."</i><br>";
    }
    echo "<img src = \"".$single_band->album->cover."\" height=350 width=350><br>";
    echo "Ascoltalo <a href=\"".$single_band->album->yt."\">qui</a><br>";
  }
}
?>