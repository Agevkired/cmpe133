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


    //include "connectionFunctions.php"; // Development Testing, Connections
    include "profileFunctions.php"; // Development Testing, Connections

    use Parse\ParseUser;
	use Parse\ParseQuery;
    use Parse\ParseObject;


    ob_start(); 
	if (!session_id()) session_start();
	
	$currentUser = "";
    if (isset($_SESSION["proConnectUserSession"])) {
        $currentUser = $_SESSION["proConnectUserSession"];
        echo "Hello " . $currentUser->get("name") .", This is the members page.<br>";
        

        /* development testing */
        //createProfile($currentUser);
        //createConnectionRequest($currentUser, "emendoza1986@gmail.com");
        //seeConnectionRequest($currentUser);
        //displayConnections($currentUser);
        createExperience($currentUser, "Google", "Analyst", 4, 2014, false, 6, 2015);
    }else{
    	echo "User not authenticated.";
	    header( "refresh:3;url=index.php" );
	    exit;
    }
    
?>
<a href="logout.php">Logout</a>
