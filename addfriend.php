<?php
	session_start();
	if(isset($_SESSION['login'])==false){
		header('Location:index.php?msg=error');
	}
	include ("base.php");
	$sql="INSERT INTO AMIS
	VALUES(NULL,:idAmi,0,:monId)";
	$req1=$bd->prepare ($sql);
	$marqueurs2=array('idAmi'=>$_POST['ajouter'],'monId'=>$_SESSION['id']);
	$req1->execute($marqueurs2) or die(print_r($req1->errorInfo()));
	$req1->closeCursor ();
	
	
	
	header('Location:./profile.php?visit='.$_POST['ajouter'].'&fr=1');
	exit();
	?>

		
