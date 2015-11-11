<?php
	require_once("../config_global.php");
	require_once("Userclass.php");
	
	$database= "if15_mats_3";
	
	session_start();
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
	//saadan ühenduse classi ja loon uue classi
	$User= new User ($mysqli);
	
	//var_dump($User->connection);
	
	
 ?>