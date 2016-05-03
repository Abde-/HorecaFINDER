<?php

// fonctions pour insertion-> une fonction par table
function insert_restos($database,$restaurants){

		foreach($restaurants as $restaurant){

		$info = $restaurant->Informations;
		$values = "(\"" . $info->Name . "\"," . $info->PriceRange . "," ;
		if (isset($info->TakeAway)){
			$values .=  "TRUE" . ","; 
		} else {
			$values .=  "FALSE" . ",";
		}

		if (isset($info->Delivery)){
			$values .=  "TRUE)";
		} else {
			$values .=  "FALSE)";
		}

		$requete = "INSERT INTO `Restaurant` " . "VALUES " . $values . ";" ;
		
		// output de test
		echo $requete . '</br>';
		$output = $database->query($requete);
	}
}
?>