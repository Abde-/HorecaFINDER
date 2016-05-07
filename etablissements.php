<!--
 *  Abdeselam El-Haman  et  Cédric Simar
 *  INFO-H-303 : Bases de données - Projet Horeca (partie 2) 
 * 
 *  PHP pour voir les etablissements
 *	
 -->

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

			<div class="col-sm-5 col-sm-offset-2 col-md-10 col-md-offset-2 main">
				<div class="panel-group">

				<?php
					$database = new mysqli("localhost","root","","horecafinder");
					$output = $database->query("SELECT * FROM `Etablissement`;");
					
					while($row = $output->fetch_assoc()) {
						echo "<div class=\"panel panel-default\">";
						echo "<div class=\"panel-heading\">". $row['Nom'] . "</div>";
						echo "<div class=\"panel-body\">Info de l'etablissement</div>";
						echo "</div>";
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
