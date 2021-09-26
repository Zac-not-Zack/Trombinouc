<?php
	session_start();
	if(isset($_SESSION['login'])==false){
		header('Location:index.php?msg=error');
	}
	include ("base.php");
	include ("../Outils/outils.php");
	$date=date("y/m/d");
	$heure=date("h:i");
	$sql="INSERT INTO PUBLICATIONS
	VALUES(NULL,:date,:heure,:id,:texte)
	";
	$req1=$bd->prepare ($sql);
	$marqueurs=array('date'=>$date,'heure'=>$heure,'id'=>$_SESSION['id'],'texte'=>$_POST['post']
	
	);
	$req1->execute($marqueurs) or die(print_r($req1->errorInfo()));
	$req1->closeCursor ();
	
	header('Location:./profile.php?');
	exit();
	
	?>