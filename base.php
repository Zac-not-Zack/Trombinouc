<?php
	include(".ht_mysql.inc");
	try {
		$bd = new PDO("mysql:host=$server;dbname=$base",   $user , $password);
		$bd->exec ('SET NAMES utf8') ;
	 }
	
	catch (Exception $e) {	
		print_r($e);
		die ("Erreur: Connexion à la base impossible");
		}



?>
