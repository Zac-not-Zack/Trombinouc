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
			<p>Envoyer un mail à votre ami(e) !</p>
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
		foreach($lesEnreg2 as $a){
			
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
					echo'<a href="envoyermail.php?envoyer=oui&id='.$lesEnreg['id'].'">'.$lesEnreg['login'].'</a>';
					echo '<br>';
					echo '<br>';
			}
			
			if($_GET['envoyer']=="oui"){ //si on veut envoyer un mail à notre ami
				
				$sql5="SELECT courrier, login FROM UTILISATEURS
		WHERE id =:id";
		$req5 = $bd->prepare($sql5);
		$marquers5=array('id'=>$_GET['id']);
		$req5->execute($marquers5) or die(print_r($req5->errorInfo()));
		$lesEnreg5=$req5->fetch();
		$req5->closeCursor();
			
			echo'<h1><u>Rédaction de mail pour '.$lesEnreg5['login'].'</u></h1>';
			echo'<form method="POST" action="./mail.php">';
			echo'<p>';	
			echo'<input id="sujet" name="sujet" type="text" placeholder=" Sujet de mail " autofocus/>';
			echo'</p>';
			echo'<p>';
			echo'<textarea id="post" name="message" rows="10" cols="50" placeholder="Envoyez-lui un mail"></textarea>';
			echo'<br>';
			echo'<button id="send" name="sonmail" type="submit" value="'.$lesEnreg5['courrier'].'">Envoyer</button>';
			echo'</p>';
			echo'</form>';
			}
			if(empty($lesEnreg)==true){
				echo '<br>';
			echo "Vous n'avez pas d'ami à qui vous pouvez envoyez un mail.";}
		?>
		</section>
		</body>  
</html>