 <?php session_start(); ?>

<!DOCTYPE html>
<html>
	<head>
		<link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<title>HorecaFINDER</title>
		<meta charset="utf-8" />
	</head>

	<!-- Bootstrap CSS core -->
	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="./bootstrap/css/dashboard.css" rel="stylesheet">
	

	<body>
		<?php
			// verification des login dans login.php
			include("./include/login.php");

			// ce code va include les menus etc -> à mettre dans chaque page
			include("./include/entete.php");
			include("./include/menus.php");
		?>

		<!-- Mettre jumbotron pour info initiale -->
		<div class="col-sm-5 col-sm-offset-2 col-md-10 col-md-offset-2 main">
			<div class="panel-group">
					<?php 
						$database = new mysqli("localhost","root","","horecafinder");
						echo "<header><h3>" . $_GET['nom'] . "<h3></header>";


						$output = $database->query("SELECT * FROM Utilisateur U WHERE U.UID = \"" . $_GET['nom'] . "\";");
						while($row = $output->fetch_assoc()){
							echo "E-mail: " . $row['Email'] . "</br>";
							echo "Enregistré le " . $row['DateEnregistrement'] . "</br></br>";
						}

						$output = $database->query("SELECT COUNT(*) FROM Commentaire C
							WHERE C.UID = \"" . $_GET['nom'] . "\";");
						while($row = $output->fetch_assoc()){
							echo "Commentaires: " .  $row['COUNT(*)'] . "</br></br>";
						}

						$output = $database->query("SELECT COUNT(*) FROM Administrateur A
													WHERE A.UID = \"" . $_GET['nom'] . "\";");
						if($row = $output->fetch_assoc()){
							echo "Statut: ";
							if ($row['COUNT(*)'] > 0){
								echo "Admin";
							}
							else{
								echo "User";
							}
						}

					?>
			</div>
		</div>

		<!-- div extra pour le menu -->
		</div>


	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="./bootstrap/js/jquery-1.12.3.min.js"></script>
	<script src="./bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
