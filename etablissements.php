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
									<input type="checkbox" value="" name="resto"
									<?php if(isset($_POST['resto'])){ echo " checked";} ?>
									>Restaurants
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" value="" name="cafe"
									<?php if(isset($_POST['cafe'])){ echo " checked";} ?>
									>Cafes
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" value="" name="hotel"
									<?php if(isset($_POST['hotel'])){ echo " checked";} ?>
									>Hotels
								</label>
							</div>
							<div class="form-group">
								<label for="etabName">Name:</label>
								<input type="text" class="form-control" name="etabName" id="etabName"
								<?php if(isset($_POST['etabName'])){ echo "value=\"".$_POST['etabName']."\"";} ?>
								>
							</div>
							<div class="form-group">
								<label for="ville">Localite:</label>
								<input type="text" class="form-control" name="ville" id="ville"
								<?php if(isset($_POST['ville'])){ echo "value=\"".$_POST['ville']."\"";} ?>
								>
							</div>

							<div class="form-group">
								<label for="ville">Tags (séparés par des virgules):</label>
								<input type="text" class="form-control" name="tags" id="tags"
								<?php if(isset($_POST['tags'])){ echo "value=\"".$_POST['tags']."\"";} ?>
								>
							</div>

							<div class="form-group">
								<label for="comm">Nb commentaires > </label>
								<select class="form-control" name ="comm"id="comm">
								<?php
									for($i = 0; $i <= 20; $i += 5){
										echo "<option ";
										if(isset($_POST['comm']) and ($_POST['comm'] == $i)) {
											echo "selected";
										}
										echo ">$i</option>";
									}
								?>
								</select>
							</div>

							<div class="form-group">
								<label for="score">Score moyen >= </label>
								<select class="form-control" name ="score"id="score">
								<?php
									for($i = 0; $i <= 5; $i ++){
										echo "<option ";
										if(isset($_POST['score']) and ($_POST['score'] == $i)) {
											echo "selected";
										}
										echo ">$i</option>";
									}
								?>
								</select>
							</div>

							<button type="submit" class="btn btn-default">Envoyer</button>
						</form>
					</div>
				</div>

				<?php


					$counter = 0;

					function whereand(){
						// returns where or and
						global $counter;
						if($counter == 0){
							$counter++;
							return " WHERE ";
						} else {
							return " AND ";
						}
					}

					$counterOr = 0;
					function orEtab(){
						global $counterOr;
						if($counterOr == 0){
							$counterOr++;
						}
						else{
							return " OR ";
						}
					}


					$database = new mysqli("localhost","root","","horecafinder");
					$requete = "SELECT * FROM `Etablissement` E";

					if(isset($_POST['etabName']) and ($_POST['etabName'] !== "")){
						$requete .= whereand() . "E.Nom LIKE '%" . $_POST['etabName'] . "%'";
					}

					if(isset($_POST['ville']) and ($_POST['ville'] !== "")){
						$requete .= whereand() . "E.Adresse_Localite LIKE '%" . $_POST['ville'] . "%'";
					}


					if(isset($_POST['comm'])){
						$requete .= whereand() . "(SELECT COUNT(*) FROM `Commentaire` C WHERE C.Nom = E.Nom)
													>= " . $_POST['comm']; 
					}

					if(isset($_POST['score'])){
						$requete .= whereand() . "(SELECT AVG(C.Score) FROM `Commentaire` C WHERE C.Nom = E.Nom)
													>= " . $_POST['score']; 
					}

					if(isset($_POST['resto']) or isset($_POST['cafe']) or isset($_POST['hotel'])){

						$requete .= whereand() . " (";
						if (isset($_POST['resto'])){ 
							$requete .= orEtab() .  "E.Nom IN (SELECT R.Nom FROM `Restaurant` R)";
						}
						if(isset($_POST['cafe'])){
							$requete .= orEtab() . "E.Nom IN (SELECT B.Nom FROM `Bar` B)";
						}
						if(isset($_POST['hotel'])){
							$requete .= orEtab() . "E.Nom IN (SELECT H.Nom FROM `Hotel` H)";
						}
						$requete.=")";
					}

					if(isset($_POST['tags']) and $_POST['tags'] !== ""){
						$counterOr = 0;
						$requete .= " AND (";
						foreach(explode(",",$_POST['tags']) as $tag){
							$requete .= orEtab() . "(SELECT COUNT(*) FROM Labelise L
													   WHERE L.Label =\"" . trim($tag)."\"
													   AND L.Nom = E.Nom) > 0";
						}
						$requete .= ")";
					}
					$requete .= ";";
					
					$output = $database->query($requete);
					
					while($row = $output->fetch_assoc()) {
						$arrayTags = [];
						$i = 0;
						$tags = $database->query("SELECT COUNT(*),L.Label from Labelise L
												  WHERE L.Nom = \"".$row['Nom']."\"
												  GROUP BY L.Label
												  ORDER BY COUNT(*) DESC;");
						while (($tag = $tags->fetch_assoc()) and ($i++ != 5)){
							// cet array aura les 5 tags les plus populaires
							array_push($arrayTags,$tag['Label']);
						}

						// some help here for the querys?
						echo "<div class=\"panel panel-default\">";
						echo 	"<div class=\"panel-heading\">
								<div class=\"pull-left\">
  								<h4><a href=\"detailEtab.php?nom=".$row['Nom']."\">"
  								 . $row['Nom'] . "</a></h4>
  								</div>
  								<div class=\"pull-right\">
  								<span class=\"text-right\">";
						foreach($arrayTags as $tag){
  							echo "<span class=\"label label-default\">". $tag ."</span> ";
  						}
  						echo "</span></br>";
  						
  						$score = $database->query("SELECT AVG(C.Score) as average from Commentaire C
  												  WHERE C.Nom = \"" . $row['Nom']."\";");
  						
  						echo "<div class=\"pull-right\">";
  						
  						$index = 0;
  						$roundScore = round($score->fetch_assoc()['average']);
  						while($index < $roundScore){
  							echo "<span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>";
  							$index++;
  						}
  						while($index < 5){
  							echo "<span class=\"glyphicon glyphicon-star-empty\" aria-hidden=\"true\"></span>";
  							$index++;
  						}

  						echo "</div>";
  						echo "</div><div class=\"clearfix\"></div></div>";

						echo "<div class=\"panel-body\"><i>". $row['Adresse_Rue'] . " " . $row['Adresse_Numero']. "</br>";
						echo $row['Adresse_CodePostal'] . " ". $row['Adresse_Localite'] . "</i></br></br>";
						echo "Téléphone: " . $row['Telephone'];
						echo "<div class = \"pull-right\"><p class=\"text-right\">Créé par <i>".
						"<a href=\"detailUser.php?nom=".$row['Createur']."\"></i>" . $row['Createur'] . "</a>"
						  ." le ". $row['DateCreation']."</p>";
						echo "</div></div></div>";
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
