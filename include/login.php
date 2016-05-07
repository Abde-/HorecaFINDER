<?php

/*  
 *  Abdeselam El-Haman  et  Cédric Simar
 *  INFO-H-303 : Bases de données - Projet Horeca (partie 2)
 * 
 *  PHP pour checker le login ou signup de l'user
 *	-> TODO: Signup et alerte si signup erroné ou login erroné
 *
*/

	// if login
	if ((isset($_POST['username'])) and ($_POST['username'] !== "")){
			
		$variable = "U.UID";
		if(strpos($_POST['username'], '@') !== FALSE){
			$variable = "U.Email";
		}
		$database = new mysqli("localhost","root","","horecafinder");
		$requete = "SELECT " . $variable . ", U.MotDePasse FROM Utilisateur U
						WHERE " . $variable . " = \"" . $_POST['username'] . "\";";
		$output = $database->query($requete);
		
		// prendre requete et checker si bon username
		if($row = $output->fetch_assoc()){
			if ($row['MotDePasse'] == $_POST['pwd']){
				// on aurait pu mettre le mail aussi ça revient au meme
				$_SESSION['username'] = $row['UID'];
			}
		}
	}

	// if signup
	if((isset($_POST['usersign'])) and ($_POST['usersign'] !== "")
		and ($_POST['pwd1sign'] == $_POST['pwd2sign'])){
		$database = new mysqli("localhost","root","","horecafinder");

		// verifier que ça existe déjà
		$requete = "SELECT * FROM Utilisateur U
					WHERE U.Email = \"" . $_POST['pwd1sign'] ."\" OR U.UID = \"". $_POST['usersign'] . "\";";
		$output = $database->query($requete);
		
		if($output->num_rows == 0){
			$values = "(\"". $_POST['usersign'] . "\",\"" . $_POST['emailsign'] . "\",\"" .
					  $_POST['pwd1sign'] . "\"," . date('Ymd',time()) . ");";
			$requete = "INSERT INTO `Utilisateur` 
						VALUES " . $values;
			$output = $database->query($requete);
			if (isset($_POST['admin'])){
				$output = $database->query("INSERT INTO `Administrateur` 
											VALUES (\"". $_POST['usersign'] ."\");");
			}
		}
	}

?>