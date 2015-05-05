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

    

    include "premiumTemplate.php";

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

    /*added */
    $results = ""; //global
//include "premiumFunctions.php";

if(isset($_POST["premiumSearch"])) {
    $company = "";
    $title = "";
    $years = "";
    $months = "";
    $degree = "";
    $school = "";
    $locale = "";
    $state = "";

    if(isset($_POST["company"]))
        $company = $_POST["company"];

    if(isset($_POST["title"]))
        $title = $_POST["title"];

    if(isset($_POST["years"]))
        $years = $_POST["years"];

    if(isset($_POST["months"]))
        $months = $_POST["months"];

    if(isset($_POST["degree"]))
        $degree = $_POST["degree"];

    if(isset($_POST["school"]))
        $school = $_POST["school"];

    if(isset($_POST["locale"]))
        $locale = $_POST["locale"];

    if(isset($_POST["state"]))
        $state = $_POST["state"];

    $months = ($years * 12) + $months;

    $results = searchify($company,$title,$months,$degree,$school,$locale,$state);
}
/*added */

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

premiumMain($currentUser, $results);

endMainDisplay();

//forumJavascript();

// END ?>
</body>
</html>

<?php
function searchify($c, $t, $m, $d, $sc, $l, $st){
    $expObjArr = array();
    $eduObjArr = array();
    $proObjArr = array();

    /* experience */
    $exp = new ParseQuery("experience");

    if($m)
        $exp = $exp->greaterThanOrEqualTo("diffMonths", $m);
    
    if($t)
        $exp = $exp->startsWith("title", $t);
    

    if($c)
        $exp = $exp->startsWith("company", $c);

    $expResults = $exp->find();

    if($expResults){
        foreach($expResults as $proEx){
            $proEx = $proEx->get("userProfile");
            $proEx->fetch();
            array_push($expObjArr, $proEx->getObjectId());
        }
    }

    /* education */
    $edu  = new ParseQuery("education");

    if($sc)
        $edu = $edu->startsWith("school", $sc);
    if($d)
        $edu = $edu->startsWith("degree", $d);

    $eduResults = $edu->find();

    if($eduResults){
        foreach($eduResults as $proEd){
            $proEd = $proEd->get("userProfile");
            $proEd->fetch();
            array_push($eduObjArr, $proEd->getObjectId());
        }
    }
    
    
    $intResult = array_intersect($expObjArr, $eduObjArr);

    /* profile */
    $profile = new ParseQuery("profile");
    if($st)
        $profile = $profile->startsWith("currentState", $st);
    if($l)
        $profile = $profile->startsWith("currentLocale", $l);

    $profileResults = $profile->find();

    if($profileResults){
        foreach($profileResults as $x){
            array_push($proObjArr, $x->getObjectId());
        }
    }
    global $result;
    $result = array_intersect($intResult, $proObjArr);
    $result = array_unique($result);
    return $result;
    /*
    if($result){
        foreach($result as $x){
            echo $x."<br>";
        }
    }
    //header("Location: premium_search_connections.php");
    exit;*/
}
?>
