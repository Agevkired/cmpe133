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

    include "mainTemplate.php";
    include "forumTemplate.php";

    include "forumFunctions.php";

    use Parse\ParseUser;
    use Parse\ParseQuery;
    use Parse\ParseObject;
    use Parse\ParseException;


    ob_start(); 
    if (!session_id()) session_start();
    
    $currentUser = "";
    if (isset($_SESSION["proConnectUserSession"])) {
        $currentUser = $_SESSION["proConnectUserSession"];
        
    }else{
        echo "User not authenticated.";
        header( "refresh:3;url=index.php" );
        exit;
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Forum! ProConnect</title>
    <!-- start main dependencies -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<!-- end main dependencies -->

	<link href="mainTemplate.css" rel="stylesheet">

    <script> 
    $(function(){
      $("#header").load("profile_header.html"); 
    });
    </script> 

</head>
<header>
<!-- START OF HEADER-->
<div id="header"></div>
</header>
<!-- END OF HEADER-->
<body onload="myFunction()"><!--fn located in forumJavascript -->

<?php // START

$name = $currentUser->get("name");
sideMenuAndStartMainDisplay($name);

forumMain();

endMainDisplay();

forumJavascript();

// END ?>
</body>
</html>
