<?php
session_start();
	if(isset($_SESSION['login'])==false){
		header('Location:index.php?msg=error');
	}
	
	include ("base.php");
	include ("../Outils/outils.php");
	if(isset($_GET['cool'])==false){ //bloquer l'access d'un ami à notre mur
	$sql="UPDATE ACCES SET acces=0
		  WHERE (_monId =:monId) AND (_idAmi =:idAmi)";
	$req = $bd->prepare($sql);
	$marquers=array('monId'=>$_SESSION['id'], 'idAmi'=>$_POST['bloquer']);
	$req->execute($marquers) or die(print_r($req->errorInfo()));
	$req->closeCursor();
	
	}
	else if($_GET['cool']=="oui"){//débloquer l'access d'un ami à notre mur
	$sql2="UPDATE ACCES SET acces=1 
		WHERE (_monId =:monId) AND (_idAmi =:idAmi)";
	$req2 = $bd->prepare($sql2);
	$marquers2=array('monId'=>$_SESSION['id'], 'idAmi'=>$_POST['bloquer']);
	$req2->execute($marquers2) or die(print_r($req2->errorInfo()));
	$req2->closeCursor();
	
	}
	header('Location:./listeami.php');
	exit();
?>
