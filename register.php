<?php
    /**
    * ProConnect
    * register.php
    * Register Page
    */

	//require '../vendor/autoload.php';
 
    /* auth.php CONTAINS PARSE DATABASE AUTHENTICATION SECRET KEYS */
    require 'auth.php';

    /* Parse Dependencies */
 	use Parse\ParseUser;
 	use Parse\ParseException;

 	/* BROWSER SESSION */
    ob_start();
	if (!session_id()) session_start();
	/* END */

	/* CHECK PHP SESSION VARIABLE FOR AUTHENTICATED USER*/
	if (isset($_SESSION["proConnectUserSession"])) {
        header("Location: members.php");
    }
    /* END */

	$registerError = ""; // ERROR MESSAGE GLOBAL VARIABLE
	$registerSuccess = ""; // ERROR MESSAGE GLOBAL VARIABLE

	/* IF REGISTER POST TRIGGERED */
	if(isset($_POST["proConnectRegister"])) {
        
        //retrieve post variables
        $username = trim($_POST["email"]);
        $firstName = trim($_POST["firstName"]);
        $lastName = trim($_POST["lastName"]);
        $pass = $_POST["password"];
        $email = trim($_POST["email"]);

        /* START of create parse user object */
        $newUser = new ParseUser();

		$newUser->set("username", $username);
		$newUser->set("password", $pass);
		$newUser->set("email", $email);
		$newUser->set("firstName", $firstName);
		$newUser->set("lastName", $lastName);
		$newUser->set("premium", false);
		/* END of create parse user object */

		/* START of parse sign up */
		try {
		  $newUser->signUp(); 
		  $registerSuccess = "Thank you for registering with ProConnect!<br>Connecting Professionals!";
		  header( "refresh:5;url=index.php" );
          
		} catch (ParseException $ex) {
            $registerError = $ex->getMessage();
		}
		/* END of parse sign up */
	}
	/* END OF REGISTER POST TRIGGERED */

?>
<!-- //////////////////// END OF PHP CODE //////////////////// -->


<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register|ProConnect</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="screen.css" rel="stylesheet">

	<script src="js/jquery-1.10.2.js"></script>
	<script> 
	$(function(){
	  $("#header").load("header.html"); 
	  $("#footer").load("footer.html"); 
	});
	</script> 
</head>
<body>
<!-- HEADER-->
<div id="header"></div>
<!--- End Of Header-->



<!--  Page Content-->
<div class="container-fluid">
    <section class="container">
    	<h1 align="center" class="register-header">Join the world's largest professional network</h1>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		<div class="container-page">				
			<div class="col-md-6">
				<h2 class="dark-grey"></h2>
				
				<img src="img/international.jpg" class="pull-left" width="450px">		
			
			</div>
		
			<div class="col-md-6">
				<h1 class="dark-grey">Get started - it's free</h1>
				<p>Registration takes less than 2 minutes.</p>

				<div class="form-group col-lg-6">
					<input type="text" name="firstName" class="form-control" id="" placeholder="First Name">
				</div>

				<div class="form-group col-lg-6">
					<input type="text" name="lastName" class="form-control" id="" placeholder="Last Name">
				</div>
				
				<div class="form-group col-lg-12">
					<input type="email" name="email" class="form-control" id="" value="" placeholder="Email Address">
				</div>

				<div class="form-group col-lg-12">
					<input type="password" name="password" class="form-control" id="" value="" placeholder="Password(6 or more characters)">
				</div>
				<?php echo "<b>".$registerError."<br><br></b>"//PRINTS PARSE AUTH ERROR?>
				<div class="form-group col-lg-12">
					<p>By clicking Join Now, you agree to ProConnect's <b>User Agreement</b>, <b>Privacy Policy</b> and <b>Cookie Policy.</b></p>
				</div>
				<div class="col-lg-6">
				<button type="submit" name="proConnectRegister" class="btn btn-primary">Join Now</button>
				</div>
			</div>
		</div>
		</form>
		<?php echo "<h1 align=\"center\" class=\"register-header\">".$registerSuccess."</h1>"//PRINTS SUCCESS MESSAGE?>
	</section>
</div>
<!-- End Of Page Content -->


<!-- START OF FOOTER-->
 <div id="footer"></div>
<!-- END OF FOOTER-->

<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>