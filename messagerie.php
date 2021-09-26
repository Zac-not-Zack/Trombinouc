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
			<p>Messagerie</p>
		</header>
		<?php
		$perlukanmenuprofile="oui";
		include("menu.php");
		?>
		<section>
		<?php
		$sql5="SELECT login FROM UTILISATEURS
		WHERE id =:id";
		$req5 = $bd->prepare($sql5);
		$marquers5=array('id'=>$_GET['id']);
		$req5->execute($marquers5) or die(print_r($req5->errorInfo()));
		$lesEnreg5=$req5->fetch();
		$req5->closeCursor();
		
		echo "<h1>Votre conversation avec ".$lesEnreg5['login']."</h1>";//Chercher tous les messages avec notre ami qu'on a choisi 
		$sq2="SELECT * FROM MESSAGE
		INNER JOIN UTILISATEURS ON _idDestinateur=id 
				WHERE ((_idDestinateur =:monId) AND (_idDestinataire =:idAmi)) OR ((_idDestinateur =:idAmi) AND (_idDestinataire =:monId)) ";
				$req2 = $bd->prepare($sq2);
				$marquers2=array('monId'=>$_GET['id'],'idAmi'=>$_SESSION['id']);
				$req2->execute($marquers2) or die(print_r($req2->errorInfo()));;
				$lesEnreg2=$req2->fetchall();
				$req2->closeCursor();
				//debug($lesEnreg2);
				if(isset($lesEnreg2)==true){
				
				foreach($lesEnreg2 as $mes){//afficher un par un les messages avec notre ami
					$q=explode("-", $mes['date']);
					$p=explode(":", $mes['heure']);
					$time=$p[0].":".$p[1];
					$date=$q[2]."/".$q[1]."/".$q[0];
					if(isset($mes['texte'])==true){
					echo '<div id="mes">';
					echo'<h2>'.$mes['prenom'].' '.$mes['nom'].'</h2>';
					echo'<h4>'.$date.' '.$time.'</h4>';
					echo'<p>'.$mes['texte'].'</p>';
					echo '</div>';
				    echo '<br>';}}}	
		
		?>
		<form method="POST" action="./refreshmessage.php?id=<?php echo $_GET['id'];?>">
			<p>
			<textarea id="send" name="send" rows="5" cols="50" placeholder="Ecrire votre message ici" autofocus></textarea>
			<br>
			<button id="envoyer">Envoyer</button> 
			</p>
			</form>
		
		</section>
		</body>  
</html>