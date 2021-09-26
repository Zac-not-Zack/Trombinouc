<?php
session_start();
	if(isset($_SESSION['login'])==false){
		header('Location:index.php?msg=error');
	}
	include ("base.php");
	include ("../Outils/outils.php");
	mail($_POST['sonmail'],$_POST['sujet'],$_POST['message']);
	header('Location:envoyermail.php');
	exit();
?>
