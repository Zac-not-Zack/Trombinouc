<?php
	session_start();
	if(isset($_SESSION['login'])==false){
		header('Location:index.php?msg=error');
	}
	include ("base.php");
	include ("../Outils/outils.php");
		$sql3="UPDATE AMIS SET status=1
			   WHERE (_monId =:idAmi) AND (idAmi=:monId)";
	$req3=$bd->prepare ($sql3);
	$marqueurs3=array('idAmi'=>$_POST['accepter'],'monId'=>$_SESSION['id']);
	$req3->execute($marqueurs3) or die(print_r($req3->errorInfo()));
	$req3->closeCursor ();
	
	//On crée la relation d'amis en deux sens
	$sql1="INSERT INTO AMIS
	VALUES(NULL,:idAmi,1,:monId)";
	$req1=$bd->prepare ($sql1);
	$marqueurs4=array('idAmi'=>$_POST['accepter'],'monId'=>$_SESSION['id']);
	$req1->execute($marqueurs4) or die(print_r($req1->errorInfo()));
	$req1->closeCursor ();
	
	
	//Donner l'accès au mur par défaut
	$sql="INSERT INTO ACCES
	VALUES(NULL,:monId,:idAmi,1)";
	$req = $bd->prepare($sql);
	$marquers=array('monId'=>$_SESSION['id'], 'idAmi'=>$_POST['accepter']);
	$req->execute($marquers) or die(print_r($req->errorInfo()));
	$req->closeCursor();
	
	$sql2="INSERT INTO ACCES
	VALUES(NULL,:idAmi,:monId,1)";
	$req2 = $bd->prepare($sql2);
	$marquers2=array('monId'=>$_SESSION['id'], 'idAmi'=>$_POST['accepter']);
	$req2->execute($marquers2) or die(print_r($req2->errorInfo()));
	$req2->closeCursor();
	
	header('Location:./profile.php');
	exit();
	?>