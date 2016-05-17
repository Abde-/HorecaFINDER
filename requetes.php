
<?php session_start(); ?>
<!-- Page où voir les requetes du prof, à faire -->
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
							<label for="requete">Requete:</label>
								<select class="form-control" name ="requete"id="requete">
									<?php
										for ($i=1; $i < 7; $i++) { 
											echo "<option>Requete ".$i."</option>";
										}
									?>
								</select>
								</br>
								<button type="submit" class="btn btn-default">Envoyer</button>
						</form>
					</div>
				</div>
				<?php
					if (isset($_POST['requete'])){
						$database = new mysqli("localhost","root","","horecafinder");
					
						if ($_POST['requete'] == "Requete 1"){
							$requete = "SELECT DISTINCT C1.UID FROM Commentaire C1
								WHERE ( SELECT COUNT(*) FROM Commentaire C2
								WHERE C1.UID = C2.UID 
								AND C2.UID <> \"Brenda\"
								AND C2.Score >= 4 
								AND C2.Nom = ANY( SELECT DISTINCT C3.Nom FROM Commentaire C3
						  		WHERE C3.Score >= 4 AND C3.UID = \"Brenda\" )) >= 3";
						  	$output = $database->query($requete);
						  	
						  	while ($row = $output->fetch_assoc()){ 
						  	echo "<div class=\"panel panel-default\">
								<div class=\"panel-body\">";
							echo $row['UID'];
							echo "</div>
							</div>";
							}
					
						} elseif ($_POST['requete'] == "Requete 2") {
							$requete = "SELECT DISTINCT C.Nom FROM Commentaire C where C.UID in
(SELECT brendaLike.UID FROM (SELECT COUNT(DISTINCT C.Nom) as howMuch, C.Nom, C.UID FROM Commentaire C 
where C.Nom in (SELECT DISTINCT C3.Nom FROM Commentaire C3
	  		  WHERE C3.Score >= 4 AND C3.UID = \"Brenda\"
              AND C.Nom = C3.Nom)
group by C.UID) as brendaLike
WHERE brendaLike.howMuch = (SELECT COUNT(DISTINCT C3.Nom) FROM Commentaire C3
	  		  WHERE C3.Score >= 4 AND C3.UID = \"Brenda\"))
AND C.UID <> \"Brenda\"";
						  	$output = $database->query($requete);
						  	
						  	while ($row = $output->fetch_assoc()){ 
						  	echo "<div class=\"panel panel-default\">
								<div class=\"panel-body\">";
							echo $row['Nom'];
							echo "</div>
							</div>";
							}
					
						}elseif ($_POST['requete'] == "Requete 3") {
							$requete = "SELECT * FROM Etablissement E
WHERE E.Nom IN 
	(SELECT C.Nom FROM Commentaire C
	GROUP BY C.Nom
	HAVING COUNT(*) > 1)";
						  	$output = $database->query($requete);
						  	
						  	while ($row = $output->fetch_assoc()){ 
						  	echo "<div class=\"panel panel-default\">
								<div class=\"panel-body\">";
							echo $row['Nom'];
							echo "</div>
							</div>";
							}
						}elseif ($_POST['requete'] == "Requete 4") {
							$requete = "SELECT DISTINCT E.Createur FROM Etablissement E
WHERE NOT EXISTS (SELECT C.UID FROM Commentaire C
			      WHERE C.Nom = E.Nom
				  AND C.UID = E.Createur)";
						  	$output = $database->query($requete);
						  	
						  	while ($row = $output->fetch_assoc()){ 
						  	echo "<div class=\"panel panel-default\">
								<div class=\"panel-body\">";
							echo $row['Createur'];
							echo "</div>
							</div>";
							}
						}elseif ($_POST['requete'] == "Requete 5") {
							$requete = "SELECT * FROM Etablissement E, Commentaire C
WHERE E.Nom = C.Nom
GROUP BY C.Nom 
HAVING COUNT(*) >= 3
ORDER BY ( SELECT AVG(C2.Score) FROM Commentaire C2
		   WHERE C.Nom = C2.Nom
		   GROUP BY C2.Nom
		   ORDER BY AVG(C2.Score)) DESC";
						  	$output = $database->query($requete);
						  	
						  	while ($row = $output->fetch_assoc()){ 
						  	echo "<div class=\"panel panel-default\">
								<div class=\"panel-body\">";
							echo $row['Nom'];
							echo "</div>
							</div>";
							}
						}else {
							$requete = "SELECT L.Label FROM Labelise L
GROUP BY L.Label
HAVING COUNT( DISTINCT L.Nom ) >= 5
ORDER BY ( SELECT AVG(C.Score) FROM Commentaire C
		   WHERE C.Nom = L.Nom )";

						  	$output = $database->query($requete);
						  	
						  	while ($row = $output->fetch_assoc()){ 
						  	echo "<div class=\"panel panel-default\">
								<div class=\"panel-body\">";
							echo $row['Label'];
							echo "</div>
							</div>";
							}
						}
					}
				?>

				<!--<div class="panel panel-default"> -->
			</div>
		</div>

		<!-- div extra pour menu -->
		</div>

	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="./bootstrap/js/jquery-1.12.3.min.js"></script>
	<script src="./bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
