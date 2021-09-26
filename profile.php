<?php
	session_start();
	
	include("./base.php");
	include ("../Outils/outils.php");
		if(isset($_GET['visit'])==false){//pour l'affichage de notre mur
	$sql="SELECT * FROM UTILISATEURS WHERE login =:login";
	$req = $bd->prepare($sql);
	$marquers=array('login'=>$_SESSION['login']);
	$req->execute($marquers);
	$lesEnreg=$req->fetch();
	$req->closeCursor();
	}
	else{//por l'affichage le mur de nos amis
	$sql="SELECT * FROM UTILISATEURS WHERE id =:login";
	$req = $bd->prepare($sql);
	$marquers=array('login'=>$_GET['visit']);
	$req->execute($marquers);
	$lesEnreg=$req->fetch();
	$req->closeCursor();
	}
	if(isset($_SESSION['login'])==false){
		
			header('Location:index.php?msg=err2');
			exit();
		
		
		}
?>		
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
		<link rel="icon" size="32x32" href="./Uploads/letter-t-icon-shiny-logo-design_14791-28.jpg">
		<title>Trombinouc-Profil</title>
	</head>
	<body>
		<!-- L'en-tête -->
		<header>
			<p>Trombinouc</p>
		</header>
<?php
$_SESSION['authentifie']="oui";	
$perlukanmenuprofile="oui";
include("menu.php");
?>
		<!-- La section -->
		<section>
		<?php
		echo '<br>';
		//reformulation de date en format jj/mm/aa
		$q=explode("-", $lesEnreg['anniversaire']);
			$bday=$q[2]."/".$q[1];
			$bdayentier=$q[2]."/".$q[1]."/".$q[0];
			$year=date("Y");
			
			//affichage de profil 
			echo '<br>';
			echo '<img class=profilepic height="200" width="170" src="'.$lesEnreg['pic'].'">';
		
		?>
			<h1> <?php echo("{$lesEnreg['prenom']} {$lesEnreg['nom']} "); ?></h1>
			<p> <?php 
			
			echo("Né(e) le {$bdayentier}<br>"); 
			echo '<br>';
			echo("Courrier : {$lesEnreg['courrier']}<br>");
			echo '<br>';
			echo("Numéro de portable : {$lesEnreg['nportable']}");
			echo '<br>';
			echo '<br>';
			echo'" '.$lesEnreg['bio'].' "'; 
			
			?></p>
			
			
			<?php
			//Publication et commentaires
				if(isset($_GET['visit'])==false){//afficher nos publications
				
				$sq2="SELECT idPub, date, heure, texte, nom, prenom, pic FROM PUBLICATIONS
				INNER JOIN UTILISATEURS ON _id=id 
				WHERE _id =:id
				ORDER BY idPub DESC";
				$req2 = $bd->prepare($sq2);
				$marquers2=array('id'=>$_SESSION['id']);
				$req2->execute($marquers2);
				$lesEnreg2=$req2->fetchall();
				$req2->closeCursor();
				echo '<br>';
				echo '<div class="publi">';
				echo '<form method="POST" action="./publication.php">';
				echo '<p>';
				echo '<textarea id="post" name="post" rows="10" cols="80" placeholder="Que voulez-vous dire?"></textarea>';
					echo '<br>';
				echo'<button name="submit" type="submit" value="'.$_GET['visit'].'" id="send">Publier</button> ';
				echo '	</p> </form>';
				echo '</div>';
				echo '<br>';
				echo '<br>';
				if(isset($lesEnreg2)==true){
				echo "<h1><u>Publications</u></h1>";
				echo '<br>';
				foreach($lesEnreg2 as $pub){
					$q=explode("-", $pub['date']);
					$p=explode(":", $pub['heure']);
					$time=$p[0].":".$p[1];
					$date=$q[2]."/".$q[1]."/".$q[0];
					echo '<div class="pub">';
					echo '<br>';
					echo '<img class=publipic  src="'.$pub['pic'].'">';
					echo'<h2>'.$pub['prenom'].' '.$pub['nom'].'</h2>';
					echo'<h4 id="datepub">'.$date.' '.$time.'</h4>';
					echo'<p>'.$pub['texte'].'</p>';
					echo '<br>';
					$sq4="SELECT date, heure, texte, nom, prenom, pic FROM COMMENTAIRES
						  INNER JOIN UTILISATEURS ON _id=id 
						  WHERE _idPubli =:id
						  ORDER BY idCom ";
					$req4 = $bd->prepare($sq4);
					$marquers4=array('id'=>$pub['idPub']);
					$req4->execute($marquers4);
					$lesEnreg4=$req4->fetchall();
					$req4->closeCursor();
					
					foreach($lesEnreg4 as $com){
						echo '<div class="comm">';
						$q3=explode("-", $com['date']);
						$p3=explode(":", $com['heure']);
						$time3=$p3[0].":".$p3[1];
						$date3=$q3[2]."/".$q3[1]."/".$q3[0];
						echo '<br>';
						echo '<img class=publipic  src="'.$com['pic'].'">';
						echo'<h2>'.$com['prenom'].' '.$com['nom'].'</h2>';
						echo'<h4 id="datepub">'.$date3.' '.$time3.'</h4>';
						echo'<p>'.$com['texte'].'</p>';
						echo '<br>';
						echo '</div>';
						echo '<br>';
						
					}
					echo '<div class="publier">';
					echo '<form method="POST" action="./commentaires.php">';
					echo '<p>';
					echo '<input type="text" id="comm" name="comm" size="95px" placeholder="Ajouter un commentaire">';
					echo'<button type="submit" id="send" name="comment" value="'.$pub['idPub'].'">Publier</button> ';
					echo '	</p> </form>';
					echo '</div>';
					echo '<br>';
					echo '</div>';
				}
				}	
				}
				//visiter le mur d'un ami
				else{
					
				
				
				$sqlnotamis="SELECT status FROM AMIS
							 WHERE (_monId =:id) AND (idAmi=:idami)";
				$reqnotamis = $bd->prepare($sqlnotamis);
				$marquers=array('id'=>$_SESSION['id'],'idami'=>$_GET['visit']);
				$reqnotamis->execute($marquers);
				$auth=$reqnotamis->fetch();
				$reqnotamis->closeCursor();
				
				$sqlrestrict="SELECT acces FROM ACCES
							  WHERE (_monId =:id) AND (_idAmi=:idami)";
				$reqrestrict = $bd->prepare($sqlrestrict);
				$marquersrest=array('idami'=>$_SESSION['id'],'id'=>$_GET['visit']);
				$reqrestrict->execute($marquersrest);
				$block=$reqrestrict->fetch();
				$reqrestrict->closeCursor();
				
				$sqlcheck="SELECT status FROM AMIS
							 WHERE (_monId =:id) AND (idAmi=:idami)";
				$reqcheck = $bd->prepare($sqlcheck);
				$marquerscheck=array('idami'=>$_SESSION['id'],'id'=>$_GET['visit']);
				$reqcheck->execute($marquerscheck);
				$check=$reqcheck->fetch();
				$reqcheck->closeCursor();
			
		
				
				if($auth['status']=='0'){
					
						echo '<p>Une invitation a été envoyées</p>';
					
					
				}
				
				else if($auth['status']==1){
				//vérification de statut de blockage
				if($block['acces']==1){
				$sq2="SELECT idPub, date, heure, texte, nom, prenom, pic FROM PUBLICATIONS
				INNER JOIN UTILISATEURS ON _id=id 
				WHERE _id =:id";
				$req2 = $bd->prepare($sq2);
				$marquers2=array('id'=>$_GET['visit']);
				$req2->execute($marquers2);
				$lesEnreg2=$req2->fetchall();
				$req2->closeCursor();
				
				//affichage de ses publications et commentaires
				if(isset($lesEnreg2)==true){
				echo "<h1>Publications</h1>";
				foreach($lesEnreg2 as $pub){
					echo '<div class="pub">';
					$q2=explode("-", $pub['date']);
					$p2=explode(":", $pub['heure']);
					$time2=$p2[0].":".$p2[1];
					$date2=$q2[2]."/".$q2[1]."/".$q2[0];
					echo '<br>';
					echo '<img class=publipic  src="'.$pub['pic'].'">';
					echo'<h2>'.$pub['prenom'].' '.$pub['nom'].'</h2>';
					echo'<h4 id="datepub">'.$date2.' '.$time2.'</h4>';
					echo'<p>'.$pub['texte'].'</p>';
				
				
					$sq4="SELECT  date, heure, texte, nom, prenom, pic FROM COMMENTAIRES
						  INNER JOIN UTILISATEURS ON _id=id 
						  WHERE _idPubli =:id
						  ORDER BY idCom";
					$req4 = $bd->prepare($sq4);
					$marquers4=array('id'=>$pub['idPub']);
					$req4->execute($marquers4);
					$lesEnreg4=$req4->fetchall();
					$req4->closeCursor();
					foreach($lesEnreg4 as $com){
						echo '<div class="comm">';
						$q4=explode("-", $com['date']);
						$p4=explode(":", $com['heure']);
						$time4=$p4[0].":".$p4[1];
						$date4=$q4[2]."/".$q4[1]."/".$q4[0];
						echo '<br>';
						echo '<img class=publipic  src="'.$com['pic'].'">';
						echo'<h2>'.$com['prenom'].' '.$com['nom'].'</h2>';
						echo'<h4 id="datepub" >'.$date4.' '.$time4.'</h4>';
						echo'<p>'.$com['texte'].'</p>';
						echo '<br>';
						echo '</div>';
						echo '<br>';
						
						
					}
					echo '<div class="publier">';
					echo '<form method="POST" action="./commentaires.php?visit='.$_GET['visit'].'">';
					echo '<p>';
					echo '<input type="text" id="comm" name="comm" size="95px" placeholder="Ajouter un commentaire">';
					echo'<button type="submit" id="send" name="comment" value="'.$pub['idPub'].'">Publier</button>';
					echo '	</p> </form>';
					echo '</div>';
					echo '<br>';
					echo '</div>';
				}}}
				else{
					echo"Vous êtes bloqué ";
				}
				}
				else {
					
					if(isset($check['status'])==true){//s'il nous a envoyé une invitation
						echo '<p>Il vous a envoyé une invitation</p>';
					}
					else{
					echo'<form method="POST" action="./addfriend.php">';
					echo'<button id="ajouter" name="ajouter" type="submit" value="'.$lesEnreg['id'].'">Ajouter</button>';
					echo'</form>';
					}
					}
				}								
						
			?>
			
			<br>
			<form method="POST" action="./search.php">
			<p>	
					<input id="search" name="search" type="search" placeholder="Search.." required /> 
					
				</p>
			</form>
		</section>
	</body>
</html>
		


