<?php
	session_start();
	session_destroy();//déconnecter de notre compte et détruit la variable session
	header('Location: index.php?exitcode=oui');
	exit();
	
?>