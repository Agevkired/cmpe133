<?php
	/**
	* ProConnect
	* members.php
	* Members only page
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
	
	$currentUser = "";
    if (isset($_SESSION["proConnectUserSession"])) {
        $currentUser = $_SESSION["proConnectUserSession"];
        echo "Hello " . $currentUser->get("username") .", This is the members page.<br>";
        if($currentUser->get("emailVerified") != true){
        	echo "An email has been sent to your inbox.<br>";
       		echo "Please verify your email: " . $currentUser->get("email") . ".<br>";
    	}
    }else{
    	echo "User not authenticated.";
	    header( "refresh:3;url=index.php" );
	    exit;
    }
    
?>
<a href="logout.php">Logout</a>
