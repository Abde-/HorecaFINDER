<?php

	// fichier test pour voir comment faire des requetes et avoir le resultat
	$database = new mysqli("localhost","root","","horecafinder"); 

	$output = $database->query("SELECT * FROM `Restaurant`;");
	while($row = $output->fetch_assoc()){
		echo "nom de resto: " . $row['Nom'] . '</br>';

	}
?>