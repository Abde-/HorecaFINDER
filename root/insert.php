<?php // fonctions pour insertion-> une fonction par table

/*	dans toutes les fonctions on suppose que les XML
	sont bien faits, donc pas de vérification si
	la donnée en soit est déjà dans la DB
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

					$requete = "INSERT INTO `Utilisateur` " . "VALUES " . $values . ";" ;
					echo $requete . '</br>';
					$database->query($requete);
				}
			}
		}

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


?>