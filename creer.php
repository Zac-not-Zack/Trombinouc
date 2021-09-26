<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
		<link rel="icon" size="32x32" href="./Uploads/letter-t-icon-shiny-logo-design_14791-28.jpg">
		<title>Trombinouc-Edit Profil</title>
	</head>
	<body>
		<!-- L'en-tête -->
		<header>
			<p>Trombinouc</p>
		</header>
	
		<section>

<?php

	include ("base.php");
	include ("../Outils/outils.php");
	
			echo "<h1>Allez hop, c'est parti!</h1>";
			echo '<form method="POST" action="./creer.php?done=oui">';
			echo '<p>	
					<input id="login" name="login" type="text" placeholder=" Login " required autofocus/> 
				</p>';
				if($_GET['login']=="error"){
					echo '<p>Le login a été pris, veuillez selectionner un autre login</p>';
			}
			echo '<p>	
					<input id="nom" name="nom" type="text" placeholder=" Nom " required autofocus/> 
					<input id="prenom" name="prenom" type="text" placeholder=" Prénom " required autofocus/> 
				</p>';
			echo '<p>	
					<input id="mdp" name="mdp" type="password" placeholder=" Password " required autofocus/> 
				</p>';
			echo '<p>	
					<label for="Homme">Homme</label>
					<input type="radio" name="genre" value="Homme" id= "genre"/> 
					<label for="Femme">Femme</label>
					<input type="radio" name="genre" value="Femme" id= "genre"/> 
					
				</p>';
			
				
			echo '<p>	
					<input id="bday" name="bday" type="date" placeholder=" Date " required autofocus/> 
				</p>';
				
			echo '<p>	
					<input id="email" name="email" type="text" placeholder=" Courrier " required autofocus/> 
				</p>';
				
			echo '<p>	
					<input id="phone" name="phone" type="text" placeholder=" Numéro de téléphone " required autofocus/> 
				</p>';
				
			echo '<p>	
					<input id="bio" name="bio" type="text" placeholder=" Petite intro " /> 
				</p>';
				
			echo '<p>	
					<button id="envoi" name="envoi" type="submit" value="envoi">On y va!</button> 
				</p>';
				
			echo '</form>';
			
				
				
			if($_GET['done']=="oui"){
	//Vérifier si login est unique ou pas
	$sql2="SELECT login FROM UTILISATEURS
			WHERE login = :login";
	$req2=$bd->prepare ($sql2);
	$marqueurs2=array('login'=>$_POST['login']);
	$req2->execute($marqueurs2); 
	$login=$req2->fetch();
	$req2->closeCursor ();
	
	if(isset($login['login'])== true){
		
	header('Location:./connex.php?nouveau=oui&login=error');
	exit();}
	$pic="./Uploads/default.jpg";//Image par défaut de Trombinouc
	$mdpchiffre=password_hash("{$_POST['mdp']}",PASSWORD_DEFAULT); //chiffrer le mdp avant de le mettre en BdB
	//Ajouter enregistrement dans UTILISATEURS
	$sql="INSERT INTO UTILISATEURS 
	VALUES(NULL,:login,:mdp,:nom,:prenom,:genre,:bday,:email,:phone,:bio,:pic)";
	$req1=$bd->prepare ($sql);
	$marqueurs=array('login'=>$_POST['login'],
	'mdp'=>$mdpchiffre,
	'nom'=>$_POST['nom'],
	'prenom'=>$_POST['prenom'],
	'genre'=>$_POST['genre'],
	'bday'=>$_POST['bday'],
	'email'=>$_POST['email'],
	'phone'=>$_POST['phone'],
	'bio'=>$_POST['bio'],
	'pic'=>$pic
	);
	$req1->execute($marqueurs) or die(print_r($req1->errorInfo()));
	$req1->closeCursor ();
	
	header('Location:./index.php');
	exit();
			}
?>
</section>
	</body>
</html>
