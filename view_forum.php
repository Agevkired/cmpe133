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
<body>

<!-- START OF HEADER-->
<div id="header"></div>
<!-- END OF HEADER-->

<!-- Content of the page-->
<div class="wrapper">
<div class="col-md-9 col-md-push-4">
	
			<img src="http://packetpushers.net/wp-content/uploads/2012/10/forumlogo.jpg" height="300px" align="center">

	<p class="h4"> Welcome To ProConnect Forum<br> <small>24 March 2015</small></p>
	<p class="text-justify">Forums allows you to add a discussion board.</p>

	<div class="btn-group btn-group-justified" role="group" aria-label="...">
	<div class="btn-group" role="group">
		<button type="button" class="btn btn-default" style="width: 100px; " >View Forum</button>
		<button  onclick="parent.location='create_forum.html'" class="btn btn-default" style="width: 110px; " >Create Forum</button>
	</div>
	</div>
	<br><br>
</div>
<div class="container">
    <div class="row">
        <form role="form">
            <div class="col-md-6 col-md-push-3">
                <?php
                    include_once('../database/connect.php');
                    $sql="SELECT * FROM Post ORDER BY post_title ASC";
                    $res = mysql_query($sql) or die(mysql_error());
                    $topics="";
                    $count =0;
                    if(mysql_num_rows($res) > 0)
                    {
                        while($row= mysql_fetch_assoc($res))
                        {
                            $id=$row['post_id'];
                            $title=$row['post_title'];
                            $creator=$row['post_creator'];
                            $date=$row['post_date'];
                           
                        $topics .="<p class='topic_blocks'><a href ='view_post.php?cid=".$id."' ><b>".$title."</b></a><br>Posted by: <font size='-1'><b>".$creator."</b> on ". $date."</font></p>";
                            $count = $count +1;
                        }
                        echo 'Total Number of Forum Posts are: '.$count;
                        echo $topics;
                    }
                    else { echo '<p>There are no Posts Available Yet!</p>';}
                ?>
            </div>
        </form>

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