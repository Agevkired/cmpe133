<?php
    /**
    * ProConnect
    * index.php
    * Login Page
    */

    /* auth.php CONTAINS PARSE DATABASE AUTHENTICATION SECRET KEYS */
    require 'auth.php';

    /* Parse Dependencies */
    use Parse\ParseUser;
    use Parse\ParseException;

    /* BROWSER SESSION */
    ob_start();
    if (!session_id()) session_start();
    define('DAYS_30', 2592000);
    /* END */

    /* CHECK PHP SESSION VARIABLE FOR AUTHENTICATED USER*/
    if (isset($_SESSION["proConnectUserSession"])) {
        header("Location: members.php");
    }
    /* END */
    
    $resetError = ""; // ERROR MESSAGE GLOBAL VARIABLE
    $resetSuccess = ""; // ERROR MESSAGE GLOBAL VARIABLE

    /* IF RESET POST TRIGGERED */
    if(isset($_POST["proConnectReset"])) {

        $email = trim($_POST["email"]);

        try {
            // Password reset request was sent successfully
            ParseUser::requestPasswordReset($email);
            $resetSuccess = "<b>An email has been sent to reset your password.</b>";
            header( "refresh:5;url=index.php" );
        } catch (ParseException $ex) {
            $resetError = "<b>".$ex->getMessage()."</b>";
        }
    }
    /* END OF RESET POST TRIGGERED*/
?>
<!-- //////////////////// END OF PHP CODE //////////////////// -->

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProConnect, Connecting Professionals!</title>
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

<!-- START OF HEADER-->
<div id="header"></div>
<!-- END OF HEADER-->

<!-- Content of the page-->
<div class="wrapper">
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<div class="login-container"> 
    <p align="center"><b>ProConnect</b></p>
    <img class="login-logo" src="img/FNI-business-handshake8.jpg" >
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email">
    <?php echo $resetError//PRINTS PARSE AUTH ERROR?>
    <?php echo $resetSuccess//PRINTS PARSE AUTH ERROR?>
  </div>
  <button type="submit" name="proConnectReset" class="btn btn-default">Sign In</button><br><br>
  Not a member?<a href="register.php">Join Now</a>
</div>


  <div class="push"></div>
 </div>
</form>
 <!-- END OF CONTENT-->

<!-- START OF FOOTER -->
 <div id="footer"></div>
<!-- END OF FOOTER -->

<!-- Adding the Background Image-->
<style>
body{
     background: url(img/social-media.jpg);  
    }
</style>

<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>