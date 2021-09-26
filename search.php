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
			<p>Trouver un pote?</p>
		</header>
<?php		
$perlukanmenuprofile="oui";
include("menu.php");
include ("base.php");
	?>	
		<!-- La section -->
		<section>
		<?php
		//chercher tous les utilisateurs
		$sql1="SELECT * FROM UTILISATEURS WHERE id!='{$_SESSION['id']}'";
		$req1 = $bd->prepare($sql1);
		$req1->execute();
		$lesEnreg1=$req1->fetchall();
		$req1->closeCursor();
		foreach($lesEnreg1 as $search){
		$var="{$search['login']} {$search['nom']} {$search['prenom']}";
		if (strpos(strtolower($var),strtolower($_POST['search']))!==false){//permet de comparer s'il y a des characters qu'on a insérer dans le nom, login ou le prenom
			echo '<img class=profilepic height="200" width="170" src="'.$search['pic'].'">';
			echo '<p><a href ="profile.php?visit='.$search['id'].'">'.$search['login'].'</a> </p>';
			echo '<p>'.$search['prenom'].' '.$search['nom'].'</p>';
			
		}
		}
	
	
		?>
		</section>
	</body>
</html>
		