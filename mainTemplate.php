<?php
require 'auth.php';

use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseException;

ob_start(); 
if (!session_id()) session_start();

$currentUser = "";
if (isset($_SESSION["proConnectUserSession"])) {
    $currentUser = $_SESSION["proConnectUserSession"];
    $currentUser->fetch();
}else{
	echo "User not authenticated.";
    header( "refresh:3;url=index.php" );
    exit;
}

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
						<?php echo $_SESSION["proConnectUserSession"]->get("email") ?>
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						
						<li> <!-- class="active" -->
							<a href="profile.php">
							<i class="glyphicon glyphicon-user"></i>
							My Profile </a>
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
						<?php 
							    $currentUser = $_SESSION["proConnectUserSession"];
    							$currentUser->fetch();
    							$premium = $currentUser->get("premium");
    							if($premium){
    								?>
						<li>
							<a href="premium_search_connections.php">
							<i class="glyphicon glyphicon-search"></i>
							Premium Search </a>
						</li>
								<?php
    							}
						?>
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

