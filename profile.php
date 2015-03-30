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


    include "connectionFunctions.php"; // Development Testing, Connections
    include "forumFunctions.php";// Development Testing, Forum

    use Parse\ParseUser;
	use Parse\ParseQuery;
    use Parse\ParseObject;


    ob_start(); 
	if (!session_id()) session_start();
	
	$currentUser = "";
    if (isset($_SESSION["proConnectUserSession"])) {
        $currentUser = $_SESSION["proConnectUserSession"];
        //$currentUser->fetch();

        /* development testing */
        //createProfile($currentUser);
        //createConnectionRequest($currentUser, "emendoza1986@gmail.com");
        //seeConnectionRequest($currentUser);
        //displayConnections($currentUser);
    }else{
    	echo "User not authenticated.";
	    header( "refresh:3;url=index.php" );
	    exit;
    }
    
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile! ProConnect</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="screen.css" rel="stylesheet">

    <script src="js/jquery-1.10.2.js"></script>
    <script> 
    $(function(){
      $("#header").load("profile_header.html"); 
      $("#footer").load("footer.html"); 
    });
    </script> 
</head>

<header>
<!-- START OF HEADER-->
<div id="header"></div>
</header>

<body>
    <div class="container">
    
        <div class="row">
        
            <div class="col-xsm-2 col-md-2">
                <div class="thumbnail">
                <img src="img/profile-photo.jpg" alt="...">
                <div class="caption">
                <h3><?php echo $currentUser->get("name") //PRINT FIRST AND LAST NAME?></h3>
                <p>
                    Bay Area, CA
                </p>
                </div>
                </div>
                
            </div>

            <div class="col-xsm-2 col-md-10">
  
                <div class="panel panel-default">
                <div class="panel-heading"><strong>Summary</strong></div>
                <div class="panel-body">
                    I like Skateboarding
                </div>
                </div>
                
                <div class="panel panel-default">
                <div class="panel-heading"><strong>Education</strong></div>
                <div class="panel-body">
                    Software Engineering, San Jose State University
                </div>
                </div>
                
                <div class="panel panel-default">
                <div class="panel-heading"><strong>Current Position</strong></div>
                <div class="panel-body">
                    I'm a Software Engineer at ProConnect.
                </div>
                </div>
                
            </div>
            
        </div>
            
    </div>

<div class="container">
    <div class="btn-group btn-group-justified" role="group" aria-label="...">
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-default">Edit Profile</button>
    </div>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-default">Connections</button>
    </div>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-default">Learn more</button>
    </div>
    </div>
</div>

<div class="container">
    <div class="jumbotron">
    
        <h3>ProConnect</br><small>Software Engineer</small></h3>
        <p> <!-- START OF PHP DEVELOPMENT TESTING -->
            <?php 
                echo "Hello " . $currentUser->get("name") .", This page is still under development.<br>";
                if($currentUser->get("emailVerified") != true){
                    echo "Reminder: An email has been sent to your inbox.<br>";
                    echo "Please verify your email: " . $currentUser->get("email") . ".<br>";
                }
                //seeConnectionRequest($currentUser);
                //displayConnections($currentUser);
                //createNewForumRoot($currentUser, "Hello World!", "First post ever!", "hello,world , first, post ,ever");
                //createForumPost("m88yAYyvqM", $currentUser, "Third post ever.");
                //displayForumRoot("m88yAYyvqM");
            ?>
        </p><!-- END OF PHP DEVELOPMENT TESTING -->
    
    </div>
</div>
<!-- START OF FOOTER -->
 <div id="footer"></div>
<!-- END OF FOOTER -->

<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
