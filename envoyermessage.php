<?php

	session_start(); 
		if (isset($_SESSION['login'])==false ){ // Authentification KO ou tentative de fraude
			header('Location:index.php?msg=err2');
		  	exit();
		}
	include ("../Outils/outils.php");
	include("./base.php");

?>
<!DOCTYPE html>  
<html>  
	<head> 
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="style.css" />
		<link rel="icon" size="32x32" href="./Uploads/letter-t-icon-shiny-logo-design_14791-28.jpg">
		<title>Trombinouc</title>
		<body>
		<!-- L'en-tête -->
		<header>
			<p>Envoyer un texto à votre ami(e) !</p>
		</header>
		<?php
		$perlukanmenuprofile="oui";
		include("menu.php");
		?>
		<section>
		
		<?php
		
		$sql2="SELECT * FROM AMIS
		WHERE (_monId =:id) AND (status=1)";
		$req2 = $bd->prepare($sql2);
		$marquers2=array('id'=>$_SESSION['id']);
		$req2->execute($marquers2) or die(print_r($req2->errorInfo()));
		$lesEnreg2=$req2->fetchall();
		$req2->closeCursor();
		//debug($lesEnreg2);
		foreach($lesEnreg2 as $a){//afficher les amis qu'on peut envoyer des messages à
			
			$sql="SELECT * FROM UTILISATEURS
			WHERE id =:id";
			$req = $bd->prepare($sql);
			$marquers=array('id'=>$a['idAmi']);
			$req->execute($marquers) or die(print_r($req->errorInfo()));
			$lesEnreg=$req->fetch();
			$req->closeCursor();
			echo '<br>';
			echo '<img class="profilepic" height="80" width="77" ';
					echo 'src='.$lesEnreg['pic'].'>';
					echo '<br>';
					echo'<a href="messagerie.php?id='.$lesEnreg['id'].'">'.$lesEnreg['login'].'</a>';
					echo '<br>';
			}
			if(empty($lesEnreg)==true){
				echo '<br>';
			echo "Vous n'avez pas d'ami à qui vous pouvez envoyez un message.";}
			
		?>
		</section>
		</body>  
</html>