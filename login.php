<?php
	error_reporting(-1);
	ini_set('display_errors', 'On');
	
	session_start();
	
	$username = $_POST['username'];			
	$password = $_POST['password'];
	
	if (strlen($username) < 4 || strlen($password) < 4) {
		echo json_encode(array(
				"success" => false,
				"msg" => "Please enter a valid username and/or password."
		));
		session_destroy();
		exit;
	}
						
	//conect to cal database as php_user
	require 'php_database.php';
				
	$isUser = $mysqli -> prepare ("select username, password
								  from users
								  where username = '$username'");
				
	if (!$isUser) {
		echo json_encode(array(
				"success" => false,
				"msg" => "Select Query Prep Failed: ", $mysqli -> error
		));
		session_destroy();
		exit;
	}
				
	$isUser -> execute();
	$isUser -> bind_result($usernameResult, $passwordResult);
	$isUser -> fetch();
	$isUser -> close();
				
	//check that username and password are valid 
	if ($usernameResult == null || !password_verify($password, $passwordResult)) {
		echo json_encode(array(
				"success" => false,
				"msg" => "Please enter a valid username and/or password."
		));
		session_destroy();
		exit;
	}
				
	$_SESSION['username'] = $username;				//creates and sets the session variable, username
	
	//echo json_encode(array(
	//		"success" => true,
	//		"msg" => $username
	//));
	
	
	//Display events as soon as they log in
	
	$showEvent = $mysqli -> prepare ("select name, cat, date, start
									 from events
									 where creator = '$username'");
	
	if (!$showEvent) {
		echo json_encode(array(
				"success" => false,
				"msg" => "Select Query Prep Failed"
		));
		exit;
	}
	
	$showEvent -> execute();
	$showEvent -> bind_result($name, $cat, $date, $start);
	
	$myArray = array(
		"success" => true,
		"msg" => $username
		);
	
	$array = array();
	
	while ($showEvent -> fetch()) {
		//array_push ($myArray, array (
		//	"name" => $name;
		//	"date" => $date,
		//	"start" => $start,
		//	"cat" => $cat
		//));
		
		$array[] = array(
			"name" => $name,
			"date" => $date,
			"start" => $start,
			"cat" => $cat
		);
	};
	
	$showEvent -> close();
	
	array_push($myArray,$array);
	
	echo json_encode($myArray);
?>