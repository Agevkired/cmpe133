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
    use Parse\ParseObject;
    use Parse\ParseQuery;
    use Parse\ParseUser;
    use Parse\ParseException;

    include "forumFunctions.php";


    function displayForumThread(){
        if(isset($_GET["fid"])){
            try {
                $forumRootObjectId = $_GET["fid"];
                $forumRoot = new ParseQuery("forumRoot");
                $forumRoot->equalTo("objectId", $forumRootObjectId );
                $forumRoot = $forumRoot->first();

                if($forumRoot){
                    $_SESSION['fid'] = $forumRootObjectId;
                    $forumRoot->fetch();

                    ?>
        <div class="container"><!--Forum Display Start -->
            <div class="row">
                <div class="col-md-8">
                  <div class="page-header">
                    <h1><small class="pull-right">45 comments</small><?php echo $forumRoot->get("title") ?></h1>
                  </div> 
                   <div class="comments-list">
              <?php 



                    $forumPostsArray = $forumRoot->get("forumPost");
                    foreach($forumPostsArray as $forumPost){
                        $forumPost->fetch();
                        $createdBy = $forumPost->get("createdBy");
                        $createdBy->fetch();

                        //echo $createdBy->get("name") . ": " .  $forumPost->get("content") . "<br>";
                        ?>
                       <div class="media">
                           <p class="pull-right"><small>5 days ago</small></p>
                            <a class="media-left" href="#">
                              <img src="http://lorempixel.com/40/40/people/1/">
                            </a>
                            <div class="media-body">
                                
                              <h4 class="media-heading user_name"><?php echo $createdBy->get("name") ?></h4>
                              <?php echo $forumPost->get("content") ?>
                              
                              <p><small><a href="">Like</a> - <a href="">Share</a></small></p>
                            </div>
                          </div>
                        <?php
                    }//end foreach
                    ?>
                    <form method="post" action="view_thread.php">
                    <div class="form-group">
                    <label for="topic_discription">Enter Comment</label>
                    <div class="input-group">
                        <textarea name="comment" id="content" class="form-control" rows="5" required></textarea>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <input type="submit" name="submitComment" id="submit" value="Submit" class="btn btn-info pull-right">
                </div>
            </div>
        </div><!--Forum Display End -->

        <?php
                }else{
                    echo "<center>Forum not found!</center>";
                }   
            } catch (ParseException $ex) {
                echo $ex->getMessage().".<br>";
            }
        }else{
            echo "<center>Forum not found!</center>";
        }
    }




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

    if(isset($_POST["submitComment"])){
        createForumPost( $_SESSION['fid'] , $currentUser, $_POST["comment"] );
        header("Location: view_thread.php?fid=".$_SESSION['fid'] );
    }
    
?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Forum! ProConnect</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="screen.css" rel="stylesheet">
    <link href="forum.css" rel="stylesheet">

    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script> 
    $(function(){
      $("#header").load("profile_header.html"); 
      $("#footer").load("footer.html"); 
    });
    </script> 
</head>
  <body>


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
        <button onclick="parent.location='view_forum.php'" type="button" class="btn btn-default" style="width: 100px; " >View Forum</button>
        <button  onclick="parent.location='create_forum.php'" class="btn btn-default" style="width: 110px; " >Create Forum</button>
    </div>
    </div>
    <br><br>
</div>
<div class="container">
    <div class="row">
            <div class="col-md-6 col-md-push-3">
                <div>
                    <?php displayForumThread()  //generateForumHere?>

                    <?php //} ?>
                </div>
                
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



</body>
</html>