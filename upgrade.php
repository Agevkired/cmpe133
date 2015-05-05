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

    include "mainTemplate.php";
    include "profileTemplate.php";

    include "connectionFunctions.php";

    use Parse\ParseUser;
    use Parse\ParseQuery;
    use Parse\ParseObject;
    use Parse\ParseException;


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
    if(isset($_GET["upgradeCode"])) {
        $id = $_GET["upgradeCode"];
        $query = ParseUser::query();
        $user = $query->equalTo("objectId", $id)->first();
        $user->set("premium",true);
        $user->save(true);
        header("Location: premium_search_connections.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Forum! ProConnect</title>
    <!-- start main dependencies -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<!-- end main dependencies -->

	<link href="mainTemplate.css" rel="stylesheet">

    <script> 
    $(function(){
      $("#header").load("profile_header.html"); 
    });
    </script> 

</head>
<header>
<!-- START OF HEADER-->
<div id="header"></div>
</header>
<!-- END OF HEADER-->
<body onload="myFunction()"><!--fn located in forumJavascript -->

<?php // START

$name = $currentUser->get("name");
sideMenuAndStartMainDisplay($name);

displayUpgrade($currentUser);

endMainDisplay();

//forumJavascript();

// END ?>
</body>
</html>
<?php
function displayUpgrade($currentUser){
        $currentUser->set("premium",true);
        $currentUser->save(true);
    ?>
    <legend class="text-center header" style="text-shadow: 2px 2px #A8A8A8;font-style: italic;"><h1>What would you receive with your Pro Account?</h1></legend>
<div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
  <div class="list-group">
    <a class="list-group-item active">
      Grow and nurture your network</a>
    <a class="list-group-item">Advanced Search</a>  
    <a class="list-group-item">Ehance your professional brand</a>
    <a class="list-group-item">Promote and grow your business</a>
    <a class="list-group-item">Maximize the power of your network</a>
  </div>
</div>
</div>
<div class="container" >
  <p>You'll pay US$99.99/year</p>
  <p>From now you can find the right people to connect with.</p>
  <p> Pay with payPal:</p>

  <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
  <!-- Business info so that we can collect the payments-->
  <input type="hidden" name="business" value="proconnect@thefreebit.com">

  <!-- Buy now button-->
  <input type="hidden" name="cmd" value="_xclick">

  <!--  Details about the item that the buyers will purchase-->
  <input type="hidden" name="item_name" value="Premium User Special!">
  <input type="hidden" name="amount" value="1">
  <input type="hidden" name="currency_code" value="USD">

  <!-- What page will be return after coming back from paypal-->
  <input type="hidden" name="return" value="upgrade.php?upgradeCode=<?php echo $currentUser->getObjectId() ?>">
  <input type="hidden" name="cancel_return" value="profile.php">

  <!-- Display the payment button-->
  <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" name="submit"
  alt="PayPal - The safer, easier way to pay online" style="margin-right:7px;">
  </form>
</div>

<div class="jumbotron">
<div class ="container">
  <img src="http://www.mortgagecalculator.org/images/time-is-money.gif" class="pull-right">
  
<p>No matter who you're looking for, Premium search filters can help you find the right people faster.</p>
<p>Your day with ProConnect Premium starts here</p>
</div>
</div>
<?php
}//end of displayUpgrade
?>