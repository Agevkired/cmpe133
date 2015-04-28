<?php
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseException;
use Parse\ParseRelation;

function connectionsMain($currentUser){?>
				<!-- Content of the page-->
				<div class="row">
					<div class="col-md-12">
    					<center>
						<img src="img/logo-connections-2.png" height="200px" align="center">

						<p class="h4">ProConnect Connections<br> <small>Connecting Professionals</small></p>
						<!-- <p class="text-justify">Forums allows you to add a discussion board.</p> -->

						<div class="btn-group btn-group-justified" role="group" aria-label="...">
							<center>
							<div class="btn-group" role="group">
    
   								<button type="button" class="btn btn-default" style="width: 100px; " >Connections</button>
   								<button  onclick="parent.location='search_connections.php'" class="btn btn-default" style="width: 110px; " >Search</button>
    
							</div>
						</div>
						<br><br>
					</div>
				</div>
				<div class="row">
           			<div class="col-md-12">
               			
                		<?php
                		seeConnectionRequest($currentUser);
                		displayConnections($currentUser);
                		?>
            			</div>
            		</div>
				</div>
				<!-- END OF CONTENT-->
<?php
} // end of connectionsMain




function connectionsSearch(){?>
				<div class="row">
					<div class="col-md-12">
    					<center>
						<img src="img/logo-connections-2.png" height="200px" align="center">

						<p class="h4">ProConnect Connections<br> <small>Connecting Professionals</small></p>
						<!-- <p class="text-justify">Forums allows you to add a discussion board.</p> -->

						<div class="btn-group btn-group-justified" role="group" aria-label="...">
							<center>
							<div class="btn-group" role="group">
    
   								<button type="button" onclick="parent.location='view_connections.php'" class="btn btn-default" style="width: 100px; " >Connections</button>
   								<button type="button" class="btn btn-default" style="width: 110px; " >Search</button>
    
							</div>
						</div>
						<br><br>
					</div>
				</div>
				<div class="row">
           			<div class="col-md-12">
   						<form role="form" method="post">
        				<input type="text" class="form-control" id="keyword" placeholder="Search by user name or email" autocomplete="off">
    					<br><br>
    					</form>
    					<div class="col-md-3"></div>
    					<div class="col-md-6">
    					<ul id="content"></ul>
    					</div>
    					<div class="col-md-3"></div>
					</div>
				</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {

        $('#keyword').on('input', function() {
            var searchKeyword = $(this).val();
            if (searchKeyword.length >= 3) {
                $.post('search.php', { keywords: searchKeyword }, function(data) {
                    $('ul#content').empty()
                    $.each(data, function() {
                        $('ul#content').append('<li><a href="create_connection.php?id=' + this.id + '">' + this.name + '</a><br> ' + this.email + '</li>');
                    });
                }, "json");
            }
        });
    });
    </script>

    <?php
} // end of connectionsSearch



function createConnectionMain( $currentUser, $uid="" ){
	try {

		$query = ParseUser::query();
   		$query->equalTo("objectId", $uid );
    	$friend = $query->first();
    	
    	if($friend){
    		$friendName = $friend->get("name");
    	?>
    	<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="profile-sidebar">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
					<img src="img/profile-photo.jpg" class="img-responsive" alt="">
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						<?php echo $friendName ?>
					</div>
					<div class="profile-usertitle-job">
						Software Engineer
					</div>
					<div>
						<h4><?php echo $friendName ?></br><small>Software Engineer</small></h4>
						Bay Area, CA
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<?php
				if(isset($_POST["connect"])){
					echo "<div class=\"profile-userbuttons\">";
        			createConnectionRequest( $currentUser, $_SESSION['id'] );
        			echo "</div></div></div>";
        			//header("Location: view_thread.php?fid=".$_SESSION['fid'] );
    			}else{
    			?>
				<div class="profile-userbuttons">
					<form method="post" action="create_connection.php">
					<button type="submit" name="connect" class="btn btn-info btn-sm">Connect</button>
					</form>
				</div>
				
			</div>
		</div>
	<?php
			}
		}
	} catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }

} // end of createConnectionMain
?>