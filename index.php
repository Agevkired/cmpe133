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

    /* CHECK COOKIE VARIABLE FOR AUTHENTICATED USER*/
    if (isset($_COOKIE["proConnectUserSession"])) {
        
        $currentUser = $_COOKIE["proConnectUserSession"];
        $currentUser->fetch(); // check for update
        $_COOKIE["proConnectUserSession"] = $currentUser; // update cookie
        $_SESSION['proConnectUserSession'] =  $currentUser; // update session
        header("Location: members.php");
    }
    /* END */

    
    $loginError = ""; // ERROR MESSAGE GLOBAL VARIABLE

    /* IF LOGIN POST TRIGGERED */
    if(isset($_POST["proConnectLogin"])) {
        
        //retrieve post variables
        $user = trim($_POST["username"]);
        $pass = $_POST["password"];

        try {
            $logIn = ParseUser::logIn($user, $pass);
            //Login request was sent successfully
            $_SESSION['proConnectUserSession'] = $logIn; // save parse user object in session
            setcookie("proConnectUserSession", $logIn, time() + DAYS_30); // set cookie with parse object
            header("Location: members.php");
        } catch (ParseException $ex) {
            $loginError = $ex->getMessage(); //set error msg
        }
    }
    /* END OF LOGIN POST TRIGGERED*/
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
    <input type="email" class="form-control" id="exampleInputEmail1" name="username" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
     <a href="passwordReset.php">Forgot the Password?</a>
     <?php echo "<br><b>".$loginError."</b>"//PRINTS PARSE AUTH ERROR?>
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox"> Remember Me
    </label>
  </div>
  <button type="submit" name="proConnectLogin" class="btn btn-default">Sign In</button><br><br>
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