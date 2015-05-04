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

function createProfile($currentUser){
    
    /* START CREATE PROFILE OBJECT */
    try {
        $profile = new ParseObject("Profile");
        $profile->set("User", $currentUser); //pointer profile->user
        $profile->set("currentPosition", "Software Engineer");
        $profile->set("currentCompany", "Google");
        $profile->set("location", "San Francisco Bay Area");
        $profile->set("state", "CA");
        $profile->save(true);
        echo "<br>successfully created profile<br>";//debugging
    } catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }
    /* END CREATE PROFILE OBJECT */

    /* start pointer user->profile */
    try {
        $currentUser->set("Profile", $profile );
        $currentUser->save(true);
        echo "successfully created pointer user->profile<br>";//debugging
    } catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }
    /* end pointer to profile object */
}

function editProfile($currentUser, $profilePicture, $currentTitle, $currentLocale, $currentState, $summary){
    $currentUser->fetch();
    $profile = $currentUser->get("profile");


    /* IF PROFILE CREATED FOR THE FIRST TIME */
    if( !$profile ){
    	$name = $currentUser->get("name");
    	$email = $currentUser->get("email");
    	$profile = new ParseObject("profile");
    	$profile->set("name", $name);
    	$profile->set("email", $email);
    	$profile->set("user", $currentUser );
    	$profile->save(true);

    	$currentUser->set("profile", $profile );
        $currentUser->save(true);
    }

	/* SET PROFILE */
    try {
    	$profile->fetch();
    	$profile->set("profilePicture", $profilePicture);
    	$profile->set("currentTitle", $currentTitle);
    	$profile->set("currentLocale", $currentLocale);
    	$profile->set("currentState", $currentState);
    	$profile->set("summary", $summary);
    	$profile->save(true);

    } catch (ParseException $ex) {
    	echo $ex->getMessage().".<br>";
    }
    header("Location: profile.php");
    exit;
}

function addEducation($currentUser, $school, $degree, $gradYear){
    $currentUser->fetch();
    $profile = $currentUser->get("profile");


    /* IF PROFILE CREATED FOR THE FIRST TIME */
    if( !$profile ){
    	$name = $currentUser->get("name");
    	$email = $currentUser->get("email");
    	$profile = new ParseObject("profile");
    	$profile->set("name", $name);
    	$profile->set("email", $email);
    	$profile->set("user", $currentUser );
    	$profile->save(true);

    	$currentUser->set("profile", $profile );
        $currentUser->save(true);
    }

	/* SET PROFILE */
    try {
    	$profile->fetch();
    	$education = new ParseObject("education");
    	$education->set("userProfile", $profile);
    	$education->set("school", $school);
    	$education->set("degree", $degree);
    	$education->set("gradYear", $gradYear);
    	$education->save(true);

    	$educationList = $profile->getRelation("educationList");
    	$educationList->add($education);
    	$profile->save(true);

    } catch (ParseException $ex) {
    	echo $ex->getMessage().".<br>";
    }
    header("Location: edit_education.php");
    exit;
} // end of AddEducation

function addExperience($currentUser, $school, $degree, $gradYear){
    $currentUser->fetch();
    $profile = $currentUser->get("profile");


    /* IF PROFILE CREATED FOR THE FIRST TIME */
    if( !$profile ){
    	$name = $currentUser->get("name");
    	$email = $currentUser->get("email");
    	$profile = new ParseObject("profile");
    	$profile->set("name", $name);
    	$profile->set("email", $email);
    	$profile->set("user", $currentUser );
    	$profile->save(true);

    	$currentUser->set("profile", $profile );
        $currentUser->save(true);
    }

	/* SET PROFILE */
    try {
    	$profile->fetch();
    	$education = new ParseObject("education");
    	$education->set("userProfile", $profile);
    	$education->set("school", $school);
    	$education->set("degree", $degree);
    	$education->set("gradYear", $gradYear);
    	$education->save(true);

    	$educationList = $profile->getRelation("educationList");
    	$educationList->add($education);
    	$profile->save(true);

    } catch (ParseException $ex) {
    	echo $ex->getMessage().".<br>";
    }
    header("Location: edit_education.php");
    exit;
} // end of AddExperience


function createExperience($currentUser, $company, $title, $sM, $sY, $present=false, $eM=0, $eY=0){

	try {
		$experience = new ParseObject("experience");
		$experience->set("userPointer", $currentUser);
		$experience->set("company", $company);
		$experience->set("title", $title);

		$startDate = new DateTime();
		$startDate->setDate($sY, $sM, 1);
		$experience->set("startDate", $startDate);

		if($present == false){
			$endDate = new DateTime();
			$endDate->setDate($eY, $eM, 1);
			$experience->set("endDate", $endDate);
		}

		$experience->save(true);
		echo "<br>successfully created experience object<br>";//debugging
	} catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }



    try {
    	$currentUser->fetch();
    	$profile = $currentUser->get("Profile");
	    $profile->fetch();
	    $profile->addUnique("experience", [$experience]);
        $profile->save(true);

        echo "<br>successfully created profile->experience object<br>";//debugging
	} catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }

}






// EDIT PROFILE FUNCTION
if(isset($_POST["editProfile"])) {

	$profilePicture = "";
	if(isset($_POST["profilePicture"])) $profilePicture = $_POST["profilePicture"];
	$currentTitle = $_POST["currentTitle"];
	$currentLocale = $_POST["currentLocale"];
	$currentState = $_POST["currentState"];
	$summary = $_POST["summary"];


	editProfile($currentUser, $profilePicture, $currentTitle, $currentLocale, $currentState, $summary);

}

if(isset($_POST["addEducation"])) {
	$school = $_POST["school"];
	$degree = $_POST["degree"];
	$gradYear = $_POST["gradYear"];

	addEducation($currentUser, $school, $degree, $gradYear);
}

if(isset($_POST["addExperience"])) {
	$company = $_POST["company"];
	$title = $_POST["title"];
	$desc = $_POST["desc"];
	$sM = $_POST["sM"];
	$sY = $_POST["sY"];
	$eM = $_POST["eM"];
	$eY = $_POST["eY"];

	addExperience($company, $title, $desc, $sM, $sY, $eM, $eM);
}
?>