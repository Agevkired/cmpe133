<?php

function forumMain(){?>
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
   								<button  onclick="parent.location='create_forum.php'" class="btn btn-default" style="width: 110px; " >Create Forum</button>
    
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
<?php
} // end of forumMain

function forumJavascript(){?>
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
<?php
} //end of forumJavascript

function forumCreateMain(){?>
<!-- Content of the page-->
<div class="row">
	<div class="col-md-12">
		<center>
		<img src="http://packetpushers.net/wp-content/uploads/2012/10/forumlogo.jpg" height="200px" align="center">
		<p class="h4">ProConnect Forums<br> <small>Connecting Professionals</small></p>

		<div class="btn-group btn-group-justified" role="group" aria-label="...">
			<center>
			<div class="btn-group" role="group">
				<button onclick="parent.location='view_forum.php'" class="btn btn-default" style="width: 100px; " >View Forum</button>
				<button type="button" class="btn btn-default" style="width: 110px; " >Create Post</button>
			</div>
		</div>
	<br><br>
	</div>
	<div class="row">
    <div class="col-md-12">


        <form role="form" action="create_forum.php" method="POST">
        	<div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="well well-sm"><strong><span class="glyphicon glyphicon-asterisk"></span>Required Field</strong></div>
                <div class="form-group">
                    <label for="topic_title">Enter Title</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter forum post title" required>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="topic_creator">Enter Search Tags</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchTags" name="searchTags" placeholder="Enter search tags seperated by commas or spaces" required>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="topic_discription">Enter Content</label>
                    <div class="input-group">
                        <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-right">
            </div>
        </form>

    </div>
</div>
  <div class="push"></div>
</div>
 <!-- END OF CONTENT-->
<?php
} //end of forumCreateMain

?>