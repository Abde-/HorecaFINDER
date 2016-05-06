<?php

/*  
 *  Abdeselam El-Haman  et  Cédric Simar
 *  INFO-H-303 : Bases de données - Projet Horeca (partie 2)
 * 
 *  PHP avec les fonctions pour parser le XML
 *
 *	-> à proteger avec mdp
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
					$values = "(\"" . $user['nickname'] . "\",\"" . $user['nickname']
					. "@horecafinder.com\", \"MotDePasse\",20000101)";

					$requete = "INSERT INTO `Utilisateur` VALUES " . $values . ";" ;
					
					echo $requete . '</br>';
					$database->query($requete);
				}
			}
		}
	// add admin associé à l'etablissement
	$requete = "INSERT INTO `Administrateur` VALUES (\"" . $etablissement['nickname'] . "\")";
		
	echo $requete . '</br>';
	$database->query($requete);
	}
}

function insert_comments($database,$etablissements){
	foreach($etablissements as $etablissement){
		if (isset($etablissement->Comments)){
			foreach($etablissement->Comments->Comment as $comment){
				
				$dateArray = explode("/",$comment['date']);
				$newDate = $dateArray[1] . "/" . $dateArray[0] . "/" . $dateArray[2];

				echo $newDate . '</br>';
				$values = "(" . $comment['score'] . ",\"" . str_replace("\"","``",$comment) .
						"\"," . date('Ymd', strtotime($newDate)) . 
						",\"" . $comment['nickname'] . "\",\"" . $etablissement->Informations->Name
						. "\")";
				$requete = "INSERT INTO `Commentaire` VALUES " . $values . ";" ;
				echo $requete . '</br>';
				$database->query($requete);
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

		$dateArray = explode("/",$etablissement['creationDate']);
		$newDate = $dateArray[1] . "/" . $dateArray[0] . "/" . $dateArray[2]; 

		$values .= "\"" . $etablissement['nickname'] . "\"," . date('Ymd',
			strtotime($newDate)) . ")";

		$requete = "INSERT INTO `Etablissement` VALUES " . $values . ";";
		
		echo "$requete </br>";
		$database->query($requete);
	}
}

function insert_bars($database,$bars){
	foreach($bars as $bar){
		$info = $bar->Informations;
		$values = "(\"" . $info->Name . "\",";
		if (isset($info->Smoking)){
			$values .=  "TRUE" . ","; 
		} else {
			$values .=  "FALSE" . ",";
		}

		if (isset($info->Snack)){
			$values .=  "TRUE" . ")"; 
		} else {
			$values .=  "FALSE" . ")";
		}

		$requete = "INSERT INTO `Bar` VALUES " . $values . ";" ;
		
		echo "$requete </br>";
		$database->query($requete);
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

		$requete = "INSERT INTO `Restaurant` VALUES " . $values . ";" ;
		
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
				$requete = "INSERT INTO `Fermeture` VALUES " . $values . ";" ;
				
				echo $requete . '</br>';
				$output = $database->query($requete);
			}
		}
	}
}

function insert_tags($database,$etablissements){
	// tags + labelise insérés dans cette fonction
	foreach ($etablissements as $etablissement) {
		if(isset($etablissement->Tags)){
			$tags = $etablissement->Tags->Tag;
			foreach($tags as $tag){
				// for tag
				$values = "(\"" . $tag['name'] . "\")";
				$requete = "INSERT INTO `Tag` VALUES " . $values . ";";
				$database->query($requete);
				
				// for labelise
				foreach($tag->User as $user){
					$username = $user['nickname'];
					$values = "(\"" . $username . "\",\"" . $etablissement->Informations->Name . 
							"\",\"" . $tag['name'] . "\")";
				
				$requete = "INSERT INTO `Labelise` VALUES " . $values . ";";

				echo $requete . '</br>';
				$database->query($requete);
				}

			}
		}
	}

}

function createTables($database){
	/* 
	prend le fichier sql et fait requete pour créer les 
	tables dans la database recemment créée
	*/
	$tables = file_get_contents('../ScriptSQL/HorecaFinder.sql');
	echo $tables;

	// haha!!! cette méthode existe pour envoyer toute les requetes d'un coup
	// salut renato :P
	$database->multi_query($tables);
}

?>
