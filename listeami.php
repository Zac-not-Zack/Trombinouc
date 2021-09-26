<?php
session_start();
	if(isset($_SESSION['login'])==false){
		header('Location:index.php?msg=error');
	}
	include ("base.php");
	include ("../Outils/outils.php");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
		<link rel="icon" size="32x32" href="./Uploads/letter-t-icon-shiny-logo-design_14791-28.jpg">
		<title>Trombinouc</title>
	</head>
	<body>
		<!-- L'en-tête -->
		<header>
			<p>Mes Amis</p>
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
		foreach($lesEnreg2 as $a){//afficher les amis un par un
			
			$sql="SELECT pic, prenom, nom, login, id FROM UTILISATEURS
			WHERE id =:id";
			$req = $bd->prepare($sql);
			$marquers=array('id'=>$a['idAmi']);
			$req->execute($marquers) or die(print_r($req->errorInfo()));
			$lesEnreg=$req->fetch();
			$req->closeCursor();
			
			$sql6="SELECT acces FROM ACCES
			WHERE (_monId =:monId) AND (_idAmi =:idAmi)";
			$req6 = $bd->prepare($sql6);
			$marquers6=array('idAmi'=>$a['idAmi'],'monId'=>$_SESSION['id']);
			$req6->execute($marquers6) or die(print_r($req6->errorInfo()));
			$lesEnreg6=$req6->fetch();
			$req6->closeCursor();
		
			echo '<br>';
			echo '<img class="profilepic" height="80" width="77" ';
			echo 'src='.$lesEnreg['pic'].'>';
			echo '<br>';
			echo '<a href="profile.php?visit='.$a['idAmi'].'">'.$lesEnreg['login'].'</a>'; 
			echo '<p>'.$lesEnreg['prenom'].' '.$lesEnreg['nom'].'</p>';
			if(isset($lesEnreg6['acces'])==false or $lesEnreg6['acces']==1 ){//si on veut bloquer leur acces à notre mur
					echo'<form method="POST" action="./bloquer.php">';
					echo'<button id="bloquer" name="bloquer" type="submit" value="'.$lesEnreg['id'].'">Restreindre son accès à ton profile</button>';
					echo'</form>';
					echo'<br>';}
				else if($lesEnreg6['acces']==0){//si on veut débloquer leur acces à notre mur
					echo'<form method="POST" action="./bloquer.php?cool=oui">';
					echo'<button id="bloquer" name="bloquer" type="submit" value="'.$lesEnreg['id'].'">Enlever la restriction</button>';
					echo'</form>';
					echo'<br>';}
		}
			if(empty($lesEnreg2)==true){
				echo '<br>';
				echo "Vous n'avez pas encore d'ami.";
			}
		?>
		</section>
	</body>
</html>
	
