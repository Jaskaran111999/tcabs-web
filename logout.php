<?php
	require_once("db-conn.php");
	session_start();
	session_destroy();

	// Redirect to the login page:
	header('location: login.php');
?>
