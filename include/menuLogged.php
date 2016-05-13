<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    		<?php echo $_SESSION['username'] ?>
    		<b class="caret"></b>
    </a>
    	
	<ul class="dropdown-menu">
		<li class="divider"></li>

		<li><a href=
		<?php 
			echo "detailUser.php?nom=".$_SESSION['username'];
		?>
		>Voir mon compte</a></li>
		<li><a href="logout.php">Logout</a></li>
		<li class="dropdown-header">Administration</li>
		<li><a href="admin.php">Créer nouveau établissement</a></li>
	</ul>
</li>