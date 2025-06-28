<?php
session_start();

	unset($_SESSION['User_id']);
	unset($_SESSION['User_name']);
	unset($_SESSION['role']);
	session_destroy();
	
	header("location:login.php");
	exit;
?>