<?php
session_start();
	if(isset($_SESSION['login'])==false){
		header('Location:index.php?msg=error');
	}
	include ("base.php");
	include ("../Outils/outils.php");
	
		
		$date=date("y/m/d");
		$heure=date("h:i");
		
		$sq3="INSERT INTO MESSAGE
		VALUES(NULL,:idSender,:idRecipient,0,:texte,:date,:heure)
		";
		$req3=$bd->prepare ($sq3);
		$marqueurs=array('idSender'=>$_SESSION['id'],'idRecipient'=>$_GET['id'],'texte'=>$_POST['send'],'date'=>$date,'heure'=>$heure);
		$req3->execute($marqueurs) or die(print_r($req3->errorInfo()));
		$req3->closeCursor ();
		
		header('Location:messagerie.php?id='.$_GET['id'].'');
		  	exit();
		?>