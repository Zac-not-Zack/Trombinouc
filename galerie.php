<?php

	session_start(); 
		if (isset($_SESSION['login'])==false ){ // Authentification KO ou tentative de fraude
			header('Location:index.php?msg=err2');
		  	exit();
		}
	include ("../Outils/outils.php");
			
?>
<!DOCTYPE html>  
<html>  
	<head> 
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="style.css" />
		<link rel="icon" size="32x32" href="./Uploads/letter-t-icon-shiny-logo-design_14791-28.jpg">
		<title>Galerie</title>
		<body>
		<!-- L'en-tête -->
		<header>
			<p>Galerie</p>
		</header>
		<?php
		$perlukanmenuprofile="oui";
		include("menu.php");
		?>
		<section>
		
			<form enctype="multipart/form-data" action="galerie.php?" method="post">
			<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
			<p>Télécharger ce fichier : </p><input name="userfile" type="file" />
			<input type="submit" value="Télécharger le fichier" />
			</form>
			
<?php


include ("base.php");
		

$uploaddir = './Uploads/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Le fichier est valide, et a été téléchargé avec succès. \n";
		   $sql="INSERT INTO GALERIE
	VALUES(NULL,:id,:photo)";
		$req1=$bd->prepare ($sql);
		$marqueurs=array('id'=>$_SESSION['id'],'photo'=>$uploadfile);
		$req1->execute($marqueurs);
		$req1->closeCursor ();
} 


		
				$sq2="SELECT photo FROM GALERIE
				INNER JOIN UTILISATEURS ON _id=id 
				WHERE _id =:id";
				$req2 = $bd->prepare($sq2);
				$marquers2=array('id'=>$_SESSION['id']);
				$req2->execute($marquers2);
				$lesEnreg2=$req2->fetchall();
				$req2->closeCursor();
		foreach($lesEnreg2 as $pic){//afficher le photo un par un
			
			echo '<img class="pic" height="200" width="170" ';
			echo 'src='.$pic['photo'].'>';
		
		
		
}

?>

		</section>
		</body>  
</html>
