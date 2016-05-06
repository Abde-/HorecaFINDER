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
	if (isset($_POST['username'])){
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
				$_SESSION['username'] = $_POST['username'];
			}
		}
	}
	// if signup -> TODO
?>