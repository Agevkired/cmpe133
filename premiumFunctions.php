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
/*
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

	
	if($result){
		foreach($result as $x){
			echo $x."<br>";
		}
	}
	//header("Location: premium_search_connections.php");
	exit;
}

function printfn(){
	if($result){
		foreach($result as $x){
			echo $x."<br>";
		}
	}

	/*
	$query = new ParseQuery("profile");
	$profiles = $query->ascending("name")->find();
	if($profiles){
		foreach($profiles as $x){
			echo $x->get("name")."<br>";
		}
	}*/

}

function searchify1($company,$title,$months,$degree,$school,$locale,$state){
	$query = new ParseQuery("profile");
	$profiles = $query->ascending("name")->find();
	if($profiles){
		foreach($profiles as $x){
			echo $x->get("name")."<br>";
		}
	}
}

/*
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

	searchify($company,$title,$months,$degree,$school,$locale,$state);
}*/

?>