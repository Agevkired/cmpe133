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

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Forum! ProConnect</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="screen.css" rel="stylesheet">

    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script> 
    $(function(){
      $("#header").load("profile_header.html"); 
      $("#footer").load("footer.html"); 
    });
    </script> 
</head>
  <body onload="myFunction()">


<!-- START OF HEADER-->
<div id="header"></div>
<!-- END OF HEADER-->

<!-- Content of the page-->
<div class="wrapper">
<div class="col-md-9 col-md-push-4">
    
            <img src="http://packetpushers.net/wp-content/uploads/2012/10/forumlogo.jpg" height="300px" align="center">

    <p class="h4"> Welcome To ProConnect Forums<br> <small>Connecting Professionals</small></p>
    <!-- <p class="text-justify">Forums allows you to add a discussion board.</p> -->

    <div class="btn-group btn-group-justified" role="group" aria-label="...">
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-default" style="width: 100px; " >View Forum</button>
        <button  onclick="parent.location='create_forum.php'" class="btn btn-default" style="width: 110px; " >Create Forum</button>
    </div>
    </div>
    <br><br>
</div>
<div class="container">
    <div class="row">
            <div class="col-md-6 col-md-push-3">
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
  <div class="push"></div>
</div>
 <!-- END OF CONTENT-->

<!-- START OF FOOTER -->
 <div id="footer"></div>
<!-- END OF FOOTER -->

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

<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript">
    function myFunction() {
        $.post('forumFunctions.php', { allForums: true }, function(data) {
                    $('#content').empty()
                    $.each(data, function() {
                        $('#content').append('<p class=\'topic_blocks\'><b>Title: <a href="addUser.php?id=' 
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
                        $('#content').append('<p class=\'topic_blocks\'><b>Title: <a href="addUser.php?id=' 
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
                        $('#content').append('<p class=\'topic_blocks\'><b>Title: <a href="addUser.php?id=' 
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

</body>
</html>