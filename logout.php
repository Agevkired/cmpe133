<?php
    /**
    * ProConnect
    * logout.php
    * Logout Page
    * @version 1.0 - 03/07/2015
    */


    /* CONTAINS */
    /* use Parse\ParseClient; AND ParseClient::initialize() */
    /* KEEP SECRET */
    require 'auth.php';
    
	use Parse\ParseUser;
    use Parse\ParseQuery;
 

	ob_start();
	if (!session_id()) session_start();

	$redirectURL = "index.php";
    $username = "";

    if (isset($_SESSION['proConnectUserSession'])) {
        $currentUser = $_SESSION['proConnectUserSession'];
        $username = $currentUser->get("username");
    }

    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 86400, '/');
    }
    session_unset();
    session_destroy();

    
    if (!$username) {
    	$logoutMsg = "No user currently logged in.";
    }else{
    	$logoutMsg = $username . " has logged out.";
    }
    header( "refresh:3;url=$redirectURL" );
 ?>

 <html>
<head>
<title></title>

<?php echo $logoutMsg ?><br>
<a href="<?php echo $redirectURL ?>">Click here to continue.</a><br>

