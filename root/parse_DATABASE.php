<?php

$myData = array("./data/Restaurants.xml","./data/Cafes.xml");
	// ici faire ce qu'il faut faire pour parse la base de données

$unparsed = file_get_contents('./data/Restaurants.xml');
$myXML = new SimpleXMLElement($unparsed);
$restaurants = $myXML->xpath("/Restaurants/Restaurant");

foreach($restaurants as $restaurant){
	// pour les attributs des labels (genre la creationDate des restaurants)
	echo $restaurant["nickname"];

	// pour les attributs des entités, comme le nom du resto etc
	echo $restaurant->Informations->Name;
}

?>