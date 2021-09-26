<div class="topbar">
<nav>
			<ul>
			<?php
				if(isset($perlukanmenuprofile)==true){
					echo"	<li><a href='profile.php'>Profil</a></li> \n";
				}
			?>
				<li><a href='notifications.php'>Notification</a></li>
				<li><a href='listeami.php'>Amis</a></li>
				<li><a href="envoyermessage.php">Messagerie</a></li>
				<li><a href="envoyermail.php">Mail</a></li>
				<li><a href="galerie.php">Galerie</a></li>
				<li><a href='editprofile.php'>Modifier le profil</a></li>
				<li><a href='deconnex.php'>Déconnexion</a></li>
				
			</ul>
		</nav>
</div>