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


    include "forumFunctions.php";

    use Parse\ParseUser;
    use Parse\ParseQuery;
    use Parse\ParseObject;


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
    <title>User Profile Sidebar - Bootsnipp.com</title>
    <!-- start main dependencies -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<!-- end main dependencies -->

	<link href="profile2.css" rel="stylesheet">

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
<body onload="myFunction()">


<div class="container">
    <div class="row profile">
		<div class="col-md-3">
			<div class="profile-sidebar">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
					<img src="img/profile-photo.jpg" class="img-responsive" alt="">
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						Marcus Doe
					</div>
					<div class="profile-usertitle-job">
						Developer
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class="profile-userbuttons">
					<button type="button" class="btn btn-success btn-sm">Follow</button>
					<button type="button" class="btn btn-danger btn-sm">Message</button>
				</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						
						<li id="test"> <!-- class="active" -->
							<a href="#">
							<i class="glyphicon glyphicon-user"></i>
							My Profile </a>
						</li>
						<li id="test2">
							<a href="#">
							<i class="glyphicon glyphicon-home"></i>
							Home </a>
						</li>
						<li>
							<a href="#">
							<i class="glyphicon glyphicon-comment"></i>
							Forum </a>
						</li>
						<li>
							<a href="#">
							<i class="glyphicon glyphicon-link"></i>
							Connections </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>
		
		<div class="col-md-9">
            <div class="profile-content" id="result">
			   
				<!-- Content of the page-->
				<div class="row">
					<div class="col-md-12">
    					<center>
						<img src="http://packetpushers.net/wp-content/uploads/2012/10/forumlogo.jpg" height="200px" align="center">

						<p class="h4">ProConnect Forums<br> <small>Connecting Professionals</small></p>
						<!-- <p class="text-justify">Forums allows you to add a discussion board.</p> -->

						<div class="btn-group btn-group-justified" role="group" aria-label="...">
							<center>
							<div class="btn-group" role="group">
    
   								<button type="button" class="btn btn-default" style="width: 100px; " >View Forum</button>
   								<button  onclick="parent.location='profile3.php'" class="btn btn-default" style="width: 110px; " >Create Forum</button>
    
							</div>
						</div>
						<br><br>
					</div>
				</div>
				<div class="row">
           			<div class="col-md-12">
               			<form role="form" method="post">
                    		<input type="text" class="form-control" id="keyword" placeholder="Search by title, search tags, user name and email">
                		</form>
                		<br>
                		<!--
                		<p class='topic_blocks'><a href ='view_post.php?cid=".$id."' ><b>Title</b></a><br>Posted by: <font size='-1'><b>Emmanuel</b> on DATE</font></p>
                		-->
                		<div id="content"></div>
                
            			</div>
            		</div>
				</div>
				<!-- END OF CONTENT-->
			</div>
    	</div>  
    </div>
</div>

<!-- START OF FOOTER -->

<style>
.topic_blocks
{
    display:block;
    background-color: #cccccc;
    padding:5px;
    color:black;
    border:1px solid black;
    margin-bottom:8px;

}
</style>

<!--<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>-->
<!--<script src="js/bootstrap.min.js"></script>-->

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
    <script type="text/javascript">
    function myFunction() {
        $.post('forumFunctions.php', { allForums: true }, function(data) {
                    $('#content').empty()
                    $.each(data, function() {
                        $('#content').append('<p class=\'topic_blocks\'><b>Title: <a href="view_thread.php?fid=' 
                            + this.id + '">' 
                            + this.title 
                            + '</a></b><br>By: ' 
                            + this.createdBy
                            + '<br>Created: '
                            + this.createdAt
                            + '<br>Last Updated: '
                            + this.updatedAt
                            + '</li>');
                    });
                }, "json");
    }
    </script>

    <script type="text/javascript">
    $(document).ready(function() {

        $('#keyword').on('input', function() {
            var searchKeyword = $(this).val();
            if (searchKeyword.length >= 3) {
                $.post('forumFunctions.php', { keywords: searchKeyword }, function(data) {
                    $('#content').empty()
                    $.each(data, function() {
                        $('#content').append('<p class=\'topic_blocks\'><b>Title: <a href="view_thread.php?fid=' 
                            + this.id + '">' 
                            + this.title 
                            + '</a></b><br>By: ' 
                            + this.createdBy
                            + '<br>Created: '
                            + this.createdAt
                            + '<br>Last Updated: '
                            + this.updatedAt
                            + '</li>');
                    });
                }, "json");
            }else if(searchKeyword.length == 0){//added
                    $.post('forumFunctions.php', { allForums: true }, function(data) {
                    $('#content').empty()
                    $.each(data, function() {
                        $('#content').append('<p class=\'topic_blocks\'><b>Title: <a href="view_thread.php?fid=' 
                            + this.id + '">' 
                            + this.title 
                            + '</a></b><br>By: ' 
                            + this.createdBy
                            + '<br>Created: '
                            + this.createdAt
                            + '<br>Last Updated: '
                            + this.updatedAt
                            + '</li>');
                    });
                }, "json");
            }//added
            
        });
    });
    </script>


<!-- END OF FOOTER -->
<!-- <script src="js/jquery-1.11.2.min.js"></script>-->
<!--<script src="js/bootstrap.min.js"></script>-->
</body>
</html>
