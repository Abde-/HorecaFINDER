<!DOCTYPE html>
<html>
	<head>
		<link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<title>HorecaFINDER</title>
		<meta charset="utf-8" />
	</head>

	<!-- Bootstrap CSS core -->
	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
	

	<body>

		<?php
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

				// encore test -> à finir
				if(mysqli_num_rows($output) > 0){
					if($_POST['password'] == )
						$_SESSION['username'] = $_POST['username']; 
				}
			}

			// if signup -> TODO

			// ce code va include les menus etc -> à mettre dans chaque page
			include("./include/entete.php");
			include("./include/menus.php");
		?>



	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="./bootstrap/js/jquery-1.12.3.min.js"></script>
	<script src="./bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>