 <?php session_start(); ?>

<!DOCTYPE html>
<html>
	<head>
		<link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<title>HorecaFINDER</title>
		<meta charset="utf-8" />
    <style>
      #map {
        width: 500px;
        height: 400px;
    	}
    </style>
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


		<?php
			//vérification si login pour commentaire
			$database = new mysqli("localhost","root","","horecafinder");

			if(isset($_SESSION['username'])){	
				if(isset($_POST['comment']) and ($_POST['comment'] !== "") ){
					$requete = "INSERT INTO `Commentaire` VALUES (".$_POST['score'].",\"".
						str_replace("\"","``",$_POST['comment'])."\",".date('Ymd', time()).",\"".$_SESSION['username']."\",\"".
						$_GET['nom']."\")";
					$database->query($requete);
				}
			}
		?>

		<?php 
			function whatIs($database,$nomEtab){
				// returns restaurant, bar or hotel
				$requete = $database->query("SELECT COUNT(*) FROM Restaurant R WHERE R.Nom = \"" . $nomEtab . "\"");
				if ($requete->fetch_assoc()['COUNT(*)'] == 0){
					$requete = $database->query("SELECT COUNT(*) FROM Bar B WHERE B.Nom = \"" . $nomEtab . "\"");
					if ($requete->fetch_assoc()['COUNT(*)'] == 0){
						return "Hotel";
					}
					else{
						return "Bar";
					}
				}
				else{
					return "Restaurant";
				}
			}
		?>

		<div class="col-sm-5 col-sm-offset-2 col-md-10 col-md-offset-2 main">
			<header><h3><?php echo $_GET['nom']; ?></h3></header></br>
			<div class="panel-body">
			<!-- requete pour données resto -->
			<?php	
				$requete = $database->query("SELECT * FROM Etablissement E WHERE E.Nom = \"".$_GET['nom']."\"" );
				$info = $requete->fetch_assoc();

				$type = whatIs($database,$_GET['nom']);
				
				$arrayTags = [];
				$tags = $database->query("SELECT COUNT(*),L.Label from Labelise L
										  WHERE L.Nom = \"".$_GET['nom']."\"
										  GROUP BY L.Label
										  ORDER BY COUNT(*) DESC;");
				while ($tag = $tags->fetch_assoc()){
					array_push($arrayTags,$tag['Label']);
				}
				
				foreach($arrayTags as $tag){
  					echo "<span class=\"label label-default\">". $tag ."</span> ";
  				}
  				echo "</br>";
  				echo "</br>";

				if($type == "Restaurant"){
					$requete = $database->query("SELECT * FROM Restaurant R WHERE R.Nom = \"" . $_GET['nom'] . "\"");
					$restoInfo = $requete->fetch_assoc();
					echo "Restaurant</br>";
					echo "Prix du plat: " . $restoInfo['FourchettePrixPlat']. "</br>";
					echo "Places max: " . $restoInfo['PlacesMax'] . "</br>";
					if ($restoInfo['Emporter']){
						echo "À emporter</br>";
					}
					if ($restoInfo['Livraison']){
						echo "Livraison</br>";
					}

				} elseif($type == "Hotel"){
					$requete = $database->query("SELECT * FROM Hotel H WHERE H.Nom = \"" . $_GET['nom'] . "\"");
					$hotelInfo = $requete->fetch_assoc();
					echo "Hotel</br>";
					echo "Nombre étoiles: " . $hotelInfo['NombreEtoiles'] . "</br>";
					echo "Nombre chambres: " . $hotelInfo['NombreChambres'] . "</br>";
					echo "Prix par nuit: " . $hotelInfo['PrixNuit'] . "</br>";
				} else {
					$requete = $database->query("SELECT * FROM Bar B WHERE B.Nom = \"" . $_GET['nom'] . "\"");
					$barInfo = $requete->fetch_assoc();
					echo "Bar</br>";
					if($barInfo['Fumeur']){
						echo "Accepte fumeur.";
					}
					if($barInfo['Snack']){
						echo "Petite restauration.";
					}
				}
				echo "</br>";
				echo "<i>". $info['Adresse_Rue'] . " " . $info['Adresse_Numero']. "</br>";
				echo $info['Adresse_CodePostal'] . " ". $info['Adresse_Localite'] . "</i></br></br>";
				echo "Téléphone: " . $info['Telephone'];
				echo "<div class = \"pull-right\"><p class=\"text-right\">Créé par <i>".
					 "<a href=\"detailUser.php?nom=".$info['Createur']."\"></i>" . $info['Createur'] . "</a>"
					 ." le ". $info['DateCreation']."</p>";
				echo "</div>";
			?>

			</br></br>
			<!-- google maps -->
			<div id="map"></div>
			<script>
				function initMap() {
					var mapDiv = document.getElementById('map');
					var etabCoord = {lat: <?php echo $info['Coordonnees_Latitude']; ?>,
									 lng: <?php echo $info['Coordonnees_Longitude']; ?>};
					var map = new google.maps.Map(mapDiv, {
						center: {lat: <?php echo $info['Coordonnees_Latitude']; ?>,
								 lng: <?php echo $info['Coordonnees_Longitude']; ?>},
						zoom: 16
        			});
        			var marker = new google.maps.Marker({
						position: etabCoord,
						map: map,
						title: <?php echo "'". $info['Nom']."'"; ?>
  					});
      			}
			</script>
			<script src="https://maps.googleapis.com/maps/api/js?callback=initMap"
			async defer></script></br>


			<div class="panel-group">				
				<?php 

				$comments = $database->query("SELECT * FROM Commentaire C WHERE C.Nom = \"" . $info['Nom'] . "\"");
				while ($comment = $comments->fetch_assoc()){
					echo "<div class=\"panel panel-default\">";
					echo 	"<div class=\"panel-heading\">";
					echo		"<h4>" . "<a href=\"detailUser.php?nom=".$comment['UID']."\">" .$comment['UID'] . "</a></h4>";
					echo	"</div>";
					echo 	"<div class=\"panel-body\">";
					echo 		$comment['Texte'];
					echo 	"<div class=\"pull-right\">";
					
					$score = $comment['Score'];
					$index = 0;
					while($index < $score){
  						echo "<span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>";
  						$index++;
  					}
  					while($index < 5){
  						echo "<span class=\"glyphicon glyphicon-star-empty\" aria-hidden=\"true\"></span>";
  						$index++;
  					}
					echo 		"</br>";
					echo 		"Le ". $comment['DateCommentaire'];
					echo 	"</div>"; 
					echo 	"</div>";
					echo "</div>";
				}
				?>

				<div class="panel panel-default">
					<div class="panel-body">
						<form role="form-inline" method = "post">
							<div class="form-group">
								<label for="comment">Comment:</label>
								<textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
							</div>
							<div class="form-group">
								<label for="score">Score: </label>
								<select class="form-control" name ="score"id="score">
								<?php
									for($i = 0; $i <= 5; $i ++){
										echo "<option>$i</option>";
									}
								?>
							</select>
							</br>
							<button type="submit" class="btn btn-default">Envoyer</button>
						</form>
					</div>
				</div>
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
