<div class="panel-group">
	<div class="panel panel-default">
		<?php 
			if(isset($_GET['modify'])){
			}
			if (isset($_POST['nom'])){
				$values = "(\"" . $_POST['nom'] . "\",\"" . $_POST['rue'] . "\",\"" . $_POST['num'] . "\",\"" .
				$_POST['cp'] . "\",\"" . $_POST['local'] . "\"," . 
				coordonnéesGoogle
				. ",\"".$_POST['tel']."\",";

				if(isset($_POST['web']) and $_POST['web'] !== ""){
					$values .= "\"".$_POST['web'] ."\",";
				} else{
					$values .= "NULL,";
				}
				$values .= "\"" . $_SESSION['username'] . "\"," . date('Ymd', time()) . ")";
				$requete = "INSERT INTO `Etablissement` VALUES " . $values;
				echo $requete;
			}
		?>
		
		<div class="panel-body">
			<form role="form-inline" method = "post">

				<div class="form-group">
					<label for="type">Type</label>
					<select class="form-control" name ="type"id="type">
						<option>Hotel</option>
						<option>Restaurant</option>
						<option>Bar</option>
					</select>
				</div>
				
				<div class="form-group">
					<label for="nom">Nom:</label>
					<input class="form-control" id="nom" name="nom">
				</div>
				<div class="form-group">
					<label for="rue">Rue:</label>
					<input class="form-control" id="rue" name="rue">
				</div>
				<div class="form-group">
					<label for="num">Numero:</label>
					<input class="form-control" id="num" name="num">
				</div>
				<div class="form-group">
					<label for="cp">Code postal:</label>
					<input class="form-control" id="cp" name="cp">
				</div>
				<div class="form-group">
					<label for="local">Localité:</label>
					<input class="form-control" id="local" name="local">
				</div>
				<div class="form-group">
					<label for="tel">Telephone:</label>
					<input class="form-control" id="tel" name="tel">
				</div>

				<div class="form-group">
					<label for="web">Site web:</label>
					<input class="form-control" id="web" name="web">
				</div>

				<div class="form-group">
					<label for="star">Nombre étoiles:</label>
					<input class="form-control" id="star" name="star">
				</div>

				<div class="form-group">
					<label for="chambre">Nombre chambres:</label>
					<input class="form-control" id="chambre" name="chambre">
				</div>
				
				<div class="form-group">
					<label for="nuit">Prix par nuit:</label>
					<input class="form-control" id="nuit" name="nuit">
				</div>

				<div class="form-group">
					<label for="plat">Prix par plat:</label>
					<input class="form-control" id="plat" name="plat">
				</div>

				<div class="form-group">
					<label for="place">Places max:</label>
					<input class="form-control" id="place" name="place">
				</div>

				<div class="form-group">
					<label class="checkbox-inline">
						<input type="checkbox" value="" name="emporter">
							Emporter
					</label>
					<label class="checkbox-inline">
						<input type="checkbox" value="" name="livraison">
							Livraison
					</label>
					<label class="checkbox-inline">
						<input type="checkbox" value="" name="fumeur">
							Fumeur
					</label>
					<label class="checkbox-inline">
						<input type="checkbox" value="" name="snack">
							Snack
					</label>
			</form>
		</div>
	</div>
</div>