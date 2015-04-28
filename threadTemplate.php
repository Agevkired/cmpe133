<?php
    /* CONTAINS */
    /* use Parse\ParseClient; AND ParseClient::initialize() */
    /* KEEP SECRET */
    require 'auth.php';
    use Parse\ParseObject;
    use Parse\ParseQuery;
    use Parse\ParseUser;
    use Parse\ParseException;
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
        <!--Forum Display Start -->
            <div class="row">
            	<div class="col-md-1"></div> 
                <div class="col-md-10">
                  <div class="page-header">
                  <h1><small class="pull-right"># comments here</small><?php echo $forumRoot->get("title") ?></h1>
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
                           <p class="pull-right"><small>date_posted_goes_here</small></p>
                            <a class="media-left" href="#">
                              <img src="http://lorempixel.com/40/40/people/1/">
                            </a>
                           	<div class="media-body">
                                
                              <h4 class="media-heading user_name"><?php echo $createdBy->get("name") ?></h4>
                              <?php echo $forumPost->get("content") ?>
                              
                              <p><small><a href="">Blank</a> - <a href="">Blank</a></small></p>
                            </div>
                          </div>
                        <?php
                    }//end foreach
                    ?>
                    <div class="col-md-1"></div>
            			<div class="col-md-10">
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
    }// END of displayForumTHread


    function displayThread(){?>
<!-- Content of the page-->
<div class="row">
	<div class="col-md-12">
		<center>
		<img src="http://packetpushers.net/wp-content/uploads/2012/10/forumlogo.jpg" height="200px" align="center">
		<p class="h4">ProConnect Forums<br> <small>Connecting Professionals</small></p>

		<div class="btn-group btn-group-justified" role="group" aria-label="...">
			<center>
    		<div class="btn-group" role="group">
        		<button onclick="parent.location='view_forum.php'" type="button" class="btn btn-default" style="width: 100px; " >View Forum</button>
        		<button  onclick="parent.location='create_forum.php'" class="btn btn-default" style="width: 110px; " >Create Forum</button>
    		</div>
    	</div>
    	<br><br>
	</div>
</div>
<div class="row">
    <div class="col-md-12">
            
                <div>
                    <?php displayForumThread()  //generateForumHere?>

                    <?php //} ?>
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
<?php
	}// end of displayTHread

?>



