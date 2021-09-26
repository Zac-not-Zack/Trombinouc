<?php
	session_start();
	if(isset($_SESSION['login'])==false){
		header('Location:index.php?msg=error');
	}
	print_r($_POST);
	include ("base.php");
	include ("../../Outils/outils.php");
	$date=date("y/m/d");
	$heure=date("h:i");
	$sql="INSERT INTO COMMENTAIRES
	VALUES(NULL,:date,:heure,:id,:idPubli,:texte)
	";
	$req1=$bd->prepare ($sql);
	$marqueurs=array('date'=>$date,'heure'=>$heure,'id'=>$_SESSION['id'],'idPubli'=>$_POST['comment'],'texte'=>$_POST['comm']);
	$req1->execute($marqueurs) or die(print_r($req1->errorInfo()));
	$req1->closeCursor ();
	
	if(isset($_GET['visit'])==false){
		header('Location:./profile.php');
		exit();
	}
	else{
		header('Location:./profile.php?visit='.$_GET['visit']);
		exit();
	}
	
	?>