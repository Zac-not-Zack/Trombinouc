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
		<title>Trombinouc-Edit Profil</title>
	</head>
	<body>
		<!-- L'en-tête -->
		<header>
			<p>Trombinouc</p>
		</header>
	<?php
			$perlukanmenuprofile="oui";
			include("menu.php");
		
	?>	
		<!-- La section -->
		<section>
			<h1>Edit Profile</h1>
			<div id="editprofile">
			<form enctype="multipart/form-data" action="editprofile.php" method="post">
			<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
			<p>Utiliser cette photo: </p><input name="userfile" type="file" />
			<input type="submit" value="Télécharger cette photo" />
			</form>
			<?php
		
			$uploaddir = './Uploads/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);






if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Le fichier est valide, et a été téléchargé
           avec succès. ";
	$sql3="UPDATE UTILISATEURS SET pic=:pic WHERE login=:login2";
	$req3=$bd->prepare ($sql3);
	$marqueurs3=array('pic'=>$uploadfile, 'login2'=>$_SESSION['login']);
	$req3->execute($marqueurs3); 
	$req3->closeCursor ();
	
} 
$sql="SELECT * FROM UTILISATEURS WHERE login =:login";
	$req = $bd->prepare($sql);
	$marquers=array('login'=>$_SESSION['login']);
	$req->execute($marquers);
	$lesEnreg=$req->fetch();
	$req->closeCursor();
	?>
			
			<form method="POST" action="./editprofile.php?fini=oui">
			<p>	
					<input id="login" name="login" type="text" value="<?php echo $lesEnreg['login'];?>" placeholder=" Login "  autofocus /> 
				</p>
				<?php
				if($_GET['login']=="error"){
					echo '<p>Le login a été pris, veuillez selectionner un autre login</p>';
					
			}
			?>
			<p>	
					<input id="nom" name="nom" type="text" value="<?php echo $lesEnreg['nom'];?>" placeholder=" Nom "  autofocus/> 
					<input id="prenom" name="prenom" type="text" value="<?php echo $lesEnreg['prenom'];?>" placeholder=" Prénom "  autofocus/> 
				</p>
			<p>	
					<input id="mdp" name="mdp" type="password" placeholder=" Nouveau Password " autofocus/> 
				</p>
			<p>	
					<label for="Homme">Homme</label>
					<input type="radio" name="genre" value="Homme" id= "genre"/> 
					<label for="Femme">Femme</label>
					<input type="radio" name="genre" value="Femme" id= "genre"/> 
					
				</p>
			
				
			<p>	
					<input id="bday" name="bday" type="date" value="<?php echo $lesEnreg['anniversaire'];?>" placeholder=" Date " autofocus/> 
				</p>
				
			<p>	
					<input id="email" name="email" type="text" value="<?php echo $lesEnreg['courrier'];?>" placeholder=" Courrier " autofocus/> 
				</p>
				
			<p>	
					<input id="phone" name="phone" type="text" value="<?php echo $lesEnreg['nportable'];?>" placeholder=" Numéro de téléphone " autofocus/> 
				</p>
				
			<p>	
					<input id="bio" name="bio" type="text" value="<?php echo $lesEnreg['bio'];?>" placeholder=" Petite intro " /> 
				</p>
				
			<p>	
					<button id="envoi" name="envoi" type="submit" value="envoi">Sauvegarder</button> 
				</p>
				
			</form>
			</div>
			<?php
	if ($_GET['fini']=="oui"){
	
	//Vérifier si login est unique ou pas
	$sql2="SELECT login FROM UTILISATEURS
			WHERE login = :login";
	$req2=$bd->prepare ($sql2);
	$marqueurs2=array('login'=>$_POST['login']);
	$req2->execute($marqueurs2); 
	$login=$req2->fetch();
	$req2->closeCursor ();
	
	$mdpchiffre=password_hash("{$_POST['mdp']}",PASSWORD_DEFAULT); //Chiffrer le mdp
	if($_SESSION['login']==$_POST['login'] ){ //si on ne change pas le login de notre compte
	$sql="UPDATE UTILISATEURS SET mdp=:mdp,nom=:nom,prenom=:prenom,genre=:genre,anniversaire=:bday,courrier=:email,nportable=:phone,bio=:bio WHERE login=:login2";
	$req1=$bd->prepare ($sql);
	$marqueurs=array(
	'mdp'=>$mdpchiffre,
	'nom'=>$_POST['nom'],
	'prenom'=>$_POST['prenom'],
	'genre'=>$_POST['genre'],
	'bday'=>$_POST['bday'],
	'email'=>$_POST['email'],
	'phone'=>$_POST['phone'],
	'bio'=>$_POST['bio'],
	'login2'=>$_SESSION['login']
	);
	$req1->execute($marqueurs) or die(print_r($req1->errorInfo()));
	$req1->closeCursor ();
	header('Location:./profile.php?');
	exit();
	}
	else if($_SESSION['login']!=$_POST['login'] ){//si on change le login
	if($login['login']==$_POST['login']) {//si le login existe déja
	header('Location:./editprofile.php?login=error');
	exit();
	}
	else{
	//Mise à jour enregistrement dans UTILISATEURS
	$sql="UPDATE UTILISATEURS SET login=:login, mdp=:mdp,nom=:nom,prenom=:prenom,genre=:genre,anniversaire=:bday,courrier=:email,nportable=:phone,bio=:bio WHERE login=:login2";
	$req1=$bd->prepare ($sql);
	$marqueurs=array('login'=>$_POST['login'],
	'mdp'=>$_POST['mdp'],
	'nom'=>$_POST['nom'],
	'prenom'=>$_POST['prenom'],
	'genre'=>$_POST['genre'],
	'bday'=>$_POST['bday'],
	'email'=>$_POST['email'],
	'phone'=>$_POST['phone'],
	'bio'=>$_POST['bio'],
	'login2'=>$_SESSION['login']
	);
	$req1->execute($marqueurs) or die(print_r($req1->errorInfo()));
	$req1->closeCursor ();
	$_SESSION['login']=$_POST['login'];
	header('Location:./profile.php?');
	exit();
	}
	}
	}
?>
		</section>
	</body>
</html>
		