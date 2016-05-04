<!-- Static navbar -->
<div class="navbar navbar-default navbar-static-top">
	<div class="container">
		<div class="navbar-header">

			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">HorecaFINDER</a>

		</div>
		<div class="navbar-collapse collapse">
			
			<!-- à changer ce truc -> à mettre en php pour afficher "Login" si non connecté -->
			<ul class="nav navbar-nav">
				<li class="active"><a href="#">Home</a></li>
				<li><a href="#about">À propos</a></li>
				<li><a href="#contact">Contact</a></li>
				
				<?php
				// dans le cas dun login
				if (isset($_POST['email'])){
					include("./include/menuLogged.php");
				}
				// dans le cas ou guest arrive
				else{
					include("./include/menuGuest.php");
				}
 
				?>
			
			</ul>

		</div>
		<!--/.nav-collapse -->

	</div>
</div>