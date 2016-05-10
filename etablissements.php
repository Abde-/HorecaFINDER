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
				<div class="panel panel-default">
					<div class="panel-body">
						<form role="form-inline" method = "post">
							<div class="form-group">
								<label class="checkbox-inline">
									<input type="checkbox" value="" name="resto">Restaurants
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" value="" name="cafe">Cafes
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" value="" name="hotel">Hotels
								</label>
							</div>
							<div class="form-group">
								<label for="usr">Name:</label>
								<input type="text" class="form-control" name="etabName" id="etabName">
							</div>
							<div class="form-group">
								<label class="checkbox-inline">
									<input type="checkbox" value="" name="snack">Snack
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" value="" name="smoke">Fumeur
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" value="" name="delivery">Livraison
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" value="" name="takeAway">À emporter
								</label>
							</div>

							<div class="form-group">
								<label for="prix">Prix < </label>
								<select class="form-control" name ="prix"id="prix">
								<?php
									for($i = 0; $i <= 100; $i += 10)
									echo "<option>$i</option>"; 
								?>
								</select>
							</div>

							<div class="form-group">
								<label for="banquet">Banquet < </label>
								<select class="form-control" name ="banquet"id="banquet">
								<?php
									for($i = 0; $i <= 100; $i += 10)
									echo "<option>$i</option>"; 
								?>
								</select>
							</div>

							<div class="form-group">
								<label for="score">Score moyen >= </label>
								<select class="form-control" name ="score"id="score">
								<?php
									for($i = 0; $i <= 10; $i ++)
									echo "<option>$i</option>"; 
								?>
								</select>
							</div>

							<button type="submit" class="btn btn-default">Envoyer</button>
						</form>
					</div>
				</div>

				<!-- panel for testing -->
				<div class="panel panel-default">
				<div class="panel-heading">
					testing
				</div>
					<div class="panel-body"> 
						<?php
							if (isset($_POST['banquet'])){
								echo $_POST['banquet'];
							}
						?>
					</div>
				</div>

				<?php
					$database = new mysqli("localhost","root","","horecafinder");
					$output = $database->query("SELECT * FROM `Etablissement`;");
					
					while($row = $output->fetch_assoc()) {

						// some help here for the querys?
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
