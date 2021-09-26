<?php
	session_start(); 
	include ("../Outils/outils.php");
		include ("base.php");
		$sql="SELECT * FROM `UTILISATEURS` WHERE login =:login";
		$req1=$bd->prepare ($sql);
		$marqueurs=array('login'=>$_POST['login']);
		$req1->execute($marqueurs);
		$mdp=$req1->fetch();
		$req1->closeCursor () or die(print_r($req1->errorInfo()));;
		$verification=password_verify($_POST['mdp'],$mdp['mdp']); //comparison entre le mdp hashé donné et celui dans BdB
		
	if(isset($_SESSION['login'])==false){
		if ($verification==false) { // Authentification KO ou tentative de fraude
			header('Location:index.php?error=ok');
		  	exit();
		}
		else {
			$_SESSION['login']=$_POST['login'];
			$_SESSION['id']=$mdp['id'];
			}
		}	
		
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
			<p>Trombinouc</p>
		</header>
		<section>
		
		<?php
		
		if($verification==true) {
			header ('Location: ./profile.php');
			exit();
			}
			
			else{
			header ('Location: ./index.php?error=ok');
			exit();
			}
			
			
		?>
		
		
		</section>
		</body>  
</html>
