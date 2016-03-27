<?php
    
	$username = $_POST['username'];			
	$passwordHash = password_hash($_POST['password'],PASSWORD_DEFAULT);
	$confirmPassword = $_POST['confirmPassword'];
	//check that username is valid
	
	
	//check that password and confirm password match
	if (password_verify('$confirmPassword', $passwordHash)) {
		echo "<p>Passwords do not match. Please try again.</p>";
		exit;
	}
	
	//conect to mod3_newsWebsite as php_user		
	require 'php_database.php';
	
	$isNewUser = $mysqli -> prepare ("select username
									 from users
									 where username = '$username'");
	
	if (!$isNewUser) {
		echo "Select Query Prep Failed: %s\n", $mysqli -> error;
		exit;
	}
	
	$isNewUser -> execute();
	$isNewUser -> bind_result($usernameResult);
	$isNewUser -> fetch();
	$isNewUser -> close();

	
	//check that username is unique
	if ($usernameResult !== null) {
		echo "<p>Username is already taken. Please try another.</p>";
		exit;
	} 
	
	$addUser = $mysqli -> prepare ("insert into users (username, password)
								   values ('$username', '$passwordHash')");
	
	if (!$addUser) {
		echo "Insert Query Prep Failed: %s\n", $mysqli->error;
		exit;
	}
	 
	$addUser -> bind_param ('ss', $username, $password);
	$addUser -> execute();
	$addUser -> close();

	$_SESSION['username'] = $username;				//creates and sets the session variable, username
	}
?>
