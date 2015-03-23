<?php
    /**
    * ProConnect
    * index.php
    * Login Page
    * @version 1.0 - 03/07/2015
    */
	//require '../vendor/autoload.php';


    /* CONTAINS */
    /* use Parse\ParseClient; AND ParseClient::initialize() */
    /* KEEP SECRET */
    require 'auth.php';

	//use Parse\ParseClient;
    use Parse\ParseUser;
    use Parse\ParseException;

	//ParseClient::initialize('ssIqti6an7anOenvJvIXBDPUurX70V6rXyKxONcx', 'eSpqAOlQ0sboJqjund2s85E9KQTcFOc8TbK6KR18', 'luEHGF6wxdZHbrVbUqB1Z4ZNsUWHfRFUszae5L0D');
    ob_start();

    if (!session_id()) session_start();
    define('DAYS_30', 2592000);

    if (isset($_SESSION["proConnectUserSession"])) {
        header("Location: members.php");
    }

    if (isset($_COOKIE["proConnectUserSession"])) {
        
        $currentUser = $_COOKIE["proConnectUserSession"];
        $currentUser->fetch();
        $_COOKIE["proConnectUserSession"] = $currentUser;
        $_SESSION['proConnectUserSession'] =  $currentUser;
        header("Location: members.php");
    }

	if(isset($_POST["proConnectLogin"])) {
        
        $user = trim($_POST["username"]);
        $pass = $_POST["password"];

   		try {

            $logIn = ParseUser::logIn($user, $pass);
            $_SESSION['proConnectUserSession'] = $logIn;
            setcookie("proConnectUserSession", $logIn, time() + DAYS_30);

            header("Location: members.php");
            exit;

        } catch (ParseException $ex) {

            echo "Login failed.<br>";
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

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
Username:<br>
<input type="text" name="username" value="" autofocus>
<br>
Password:<br>
<input type="password" name="password" value="">
<br><br>
<input type="submit" name="proConnectLogin" value="Login">
</form>
<p><a href="register.php">Register</a></p>

</body>
</html>
