<?php // fonctions pour insertion-> une fonction par table

/*	dans toutes les fonctions on suppose que les XML
	sont bien faits, donc pas de vérification si
	la donnée en soit est déjà dans la DB

	TODO:
	- Hotel -> nope in XML
	- Bar
	- Administrateur -> nope in XML
	- Commentaire
	- Tag
	- Labelise
*/

function insert_users($database,$etablissements){

	foreach($etablissements as $etablissement){
		$info = $etablissement;

		if (isset($etablissement->Comments)){
			foreach($etablissement->Comments->Comment as $comment){
				// verifier d'abord si user existe dans DB? -> TODO
				$values = "(\"" . $comment['nickname'] . "\",\"" . $comment['nickname']
				. "@horecafinder.com\", \"MotDePasse\",20000101)";

				$requete = "INSERT INTO `Utilisateur` " . "VALUES " . $values . ";" ;
				$database->query($requete);
			}
		}

		if (isset($etablissement->Tags)){
			foreach($etablissement->Tags->Tag as $tag){
				foreach($tag->User as $user){
					$values = "(\"" . $user['nickname'] . "\",\"" . $comment['nickname']
					. "@horecafinder.com\", \"MotDePasse\",20000101)";

					$requete = "INSERT INTO `Utilisateur` VALUES " . $values . ";" ;
					echo $requete . '</br>';
					$database->query($requete);
				}
			}
		}

	}
}

function insert_etabl($database,$etablissements){
	// function pour rajouter les etablissements

	foreach($etablissements as $etablissement){
		$info = $etablissement->Informations;
		$addr = $info->Address;
		$values = "(\"" . $info->Name . "\",\"" . $addr->Street . "\",\"" . $addr->Num . "\",\"" .
				$addr->Zip . "\",\"" . $addr->City . "\",";
		if (isset($addr->Longitude)){
			$values .= "\"" . $addr->Longitude . "\",";
		} else {
			$values .= "NULL" . ",";
		}

		if (isset($addr->Latitude)){
			$values .= "\"" . $addr->Latitude . "\",";
		} else {
			$values .= "NULL" . ",";
		}

		$values .= "\"" . $info->Tel . "\",";

		if (isset($info->Site)){
			$values .= "\"" . $info->Site['link'] . "\",";
		} else {
			$values .= "NULL" . ",";
		}

		$values .= "\"" . $etablissement['nickname'] . "\"," . date('Ymd',
			strtotime($etablissement['creationDate'])) . ")";

		$requete = "INSERT INTO `Etablissement` VALUES " . $values . ";";
		$database->query($requete);
		echo "$requete </br>";
	}
}

function insert_restos($database,$restaurants){

	foreach($restaurants as $restaurant){

		$info = $restaurant->Informations;
		$values = "(\"" . $info->Name . "\"," . $info->PriceRange . "," 
		. $info->Banquet['capacity'] . ",";
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

function insert_fermeture($database,$etablissements){
	foreach($etablissements as $etablissement){
		if(isset($etablissement->Informations->Closed)){
			$whenArray = $etablissement->Informations->Closed->On;
			foreach($whenArray as $closed){
				if (isset($closed['hour'])){
					$hour = "\"" . $closed['hour'] . "\"";
				} else {
					$hour = 'NULL';
				}
				
				$day = $closed['day'];
				
				$values = "(\"" . $etablissement->Informations->Name . "\"," . 
				$day . "," . $hour . ")";
				$requete = "INSERT INTO `Fermeture` " . "VALUES " . $values . ";" ;
				echo $requete . '</br>';
			}
		}
	}
}

function insert_tags($database,$etablissement){
	// tags + labelise insérés dans cette fonction
	

}

?>
