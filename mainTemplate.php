<?php


function sideMenuAndStartMainDisplay( $name ){
?>
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
						<?php echo $name ?>
					</div>
					<div class="profile-usertitle-job">
						Current Title
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
						
						<li> <!-- class="active" -->
							<a href="profile.php">
							<i class="glyphicon glyphicon-user"></i>
							My Profile </a>
						</li>
						<li>
							<a href="home.php">
							<i class="glyphicon glyphicon-home"></i>
							Home </a>
						</li>
						<li>
							<a href="view_forum.php">
							<i class="glyphicon glyphicon-comment"></i>
							Forum </a>
						</li>
						<li>
							<a href="view_connections.php">
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
<?php
} // END of sideMenuDisplay


function endMainDisplay(){
?>
			</div>
    	</div>  
    </div>
</div>
<?php
}// END of endMainDisplay

?>

