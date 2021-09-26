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
			<p >Notifications</p>
		</header>
		<?php
			$perlukanmenuprofile="oui";
			include("menu.php");
			?>
		<section>
			<?php
			echo '<div class="noti">';		
		//Friend requests
			echo "<h1><u>Invitation d'amis</u></h1>";
			$sql3="SELECT * FROM AMIS
			INNER JOIN UTILISATEURS ON _monId=id
			WHERE idAmi =:id";
			$req3 = $bd->prepare($sql3);
			$marquers3=array('id'=>$_SESSION['id']);
			$req3->execute($marquers3) or die(print_r($req3->errorInfo()));
			$lesEnreg3=$req3->fetchall();
			$req3->closeCursor();
			//debug($lesEnreg3); 
			
			foreach($lesEnreg3 as $friend){//afficher les amis
				if($friend['status']==0){
					echo '<img class="profilepic" height="80" width="77" ';
					echo 'src='.$friend['pic'].'>';
					echo'<p>'.$friend['login'].' vous a envoyé une invitation</p>';
					echo'<form method="POST" action="./acceptfriend.php">';
					echo'<button id="accepter" name="accepter" type="submit" value="'.$friend['id'].'">Accepter</button>';
					echo'</form>';
					echo'<br>';
					$g="r";//on déclare une variable afin de savoir s'il ya des invitation
				}
				
			}
		if(isset($g)==false){//s'il n'y a pas des invitation
		echo "Aucune nouvelle invitation.";
		echo "<br>";}
		echo "<br>";
			?>
			</div>
			<br>
			<div class="noti">
			
			<h1><u>Anniversaires</u></h1>
			<?php
			$date= date("d/m");
			
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
			
			$q=explode("-", $lesEnreg['anniversaire']);
			$bday=$q[2]."/".$q[1];
			$bdayentier=$q[2]."/".$q[1]."/".$q[0];
			
			
			if($date==$bday){//si la date de notre amis est la meme date d'aujourd'hui
				
			echo "<br>";
			echo "<p>C'est l'anniversaire de ".$lesEnreg['prenom'].' '.$lesEnreg['nom']." ajd! Souhaitez-lui une excellente journée par mail!</p>";
			echo '<img class="profilepic" height="80" width="77" ';
			echo 'src='.$lesEnreg['pic'].'>';
			echo '<br>';
			echo '<p>'.$lesEnreg['prenom'].' '.$lesEnreg['nom'].'</p>';
			echo "Son anniversaire est ".$bdayentier."!";
			if($lesEnreg['genre']=="Homme"){
				echo " Il ";}
			else {echo " Elle ";}
			echo "a ".age($q[0])." aujourd'hui!";
			
			
			
					
			echo'<form method="POST" action="./mail.php">';
			echo'<p>';	
			echo'<input id="sujet" name="sujet" type="text" placeholder=" Sujet de mail " />';
			echo'</p>';
			echo'<p>';
			echo'<textarea id="post" name="message" rows="10" cols="50" placeholder="Envoyez-lui un petit mail pour son anniversaire"></textarea>';
			echo'<br>';
			echo'<button id="send" name="sonmail" type="submit" value="'.$lesEnreg['courrier'].'">Envoyer</button>';
			echo'</p>';
			echo'</form>';
			$temp="oui";
			}
			
				
			

		
		}
		if(isset($temp)==false){
			echo "Aucune notification concernant l'anniversaire.";}
		echo '</div>';	

		?>
			</section>
		</body>  
</html>
