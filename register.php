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
        
        $username = trim($_POST["email"]);
        $name = trim($_POST["name"]);
        $pass = $_POST["password"];
        $email = trim($_POST["email"]);

        $newUser = new ParseUser();

		$newUser->set("username", $username);
		$newUser->set("password", $pass);
		$newUser->set("email", $email);
		$newUser->set("name", $name);
		$newUser->set("premium", false);


		try {
		  $newUser->signUp();
		  echo "Thank you for registering with ProConnect! Connecting Professionals!";
		  header( "refresh:4;url=index.php" );
          exit;
		} catch (ParseException $ex) {
            echo "Registration error.<br>";
            //echo $ex->getCode();
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
Full Name:<br>
<input type="text" name="name" value="" autofocus>
<br><br>
Email:<br>
<input type="text" name="email" value="">
<br><br>
Password:<br>
<input type="password" name="password" value="">
<br><br>
<input type="submit" name="proConnectRegister" value="Register">
</form>
<p><a href="index.php">Login</a></p>

</body>
</html>
