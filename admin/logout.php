<?php
	session_start();
	unset($_SESSION['User_name']);
	unset($_SESSION['User_id']);
	unset($_SESSION['role']);
// print_r($_SESSION);

	session_destroy();
	
	header("Location:login.php");
	exit();

?>