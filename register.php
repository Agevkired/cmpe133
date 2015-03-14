<?php
	require '../vendor/autoload.php';
 
    /* CONTAINS */
    /* use Parse\ParseClient; AND ParseClient::initialize() */
    /* KEEP SECRET */
    require 'auth.php';

 	use Parse\ParseUser;
 	use Parse\ParseException;


    ob_start();
	if (!session_id()) session_start();
	
	if (isset($_SESSION["proConnectUserSession"])) {
        header("Location: members.php");
    }
	
	if(isset($_POST["proConnectRegister"])) {
        
        $username = trim($_POST["username"]);
        $pass1 = $_POST["password1"];
        $pass2 = $_POST["password2"];
        $email = trim($_POST["email"]);

        $newUser = new ParseUser();

		$newUser->set("username", $username);

		$myEx = "";
		if($pass1 == $pass2){
			$newUser->set("password", $pass1);
		}else{
			$myEx = "Passwords do not match.<br>";
		}

		$newUser->set("email", $email);
		$newUser->set("premium", false);


		try {
		  $newUser->signUp();
		  echo "Thank you for registering with ProConnect! Connecting Professionals!";
		  header( "refresh:4;url=index.php" );
          exit;
		} catch (ParseException $ex) {
            echo "Registration error.<br>";
            //echo $ex->getCode();
            echo $myEx;
            echo $ex->getMessage().".<br>";

		}

	}
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
<br>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
Username:<br>
<input type="text" name="username" value="" autofocus>
<br><br>
Password:<br>
<input type="password" name="password1" value="">
<br><br>
Confirm Password:<br>
<input type="password" name="password2" value="">
<br><br>
Email:<br>
<input type="text" name="email" value="">
<br><br>
<input type="submit" name="proConnectRegister" value="Register">
</form>
<p><a href="index.php">Login</a></p>

</body>
</html>
