<?php

// fichier avec les fonctions d'insertion
include("./insert.php");

$unparsed = file_get_contents('./data/Restaurants.xml');
$myXML = new SimpleXMLElement($unparsed);
$restaurants = $myXML->xpath("/Restaurants/Restaurant");

// localhost et données à changer si jamais
$database = new mysqli("localhost","root","","horecafinder"); 

// requetes se font dans chaque fonction
//insert_users($database,$restaurants);
//insert_etabl($database,$restaurants);
insert_fermeture($database,$restaurants);
//insert_restos($database,$restaurants);

?>