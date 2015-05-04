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

function addExperience($currentUser, $company, $title, $desc, $sM, $sY, $eM, $eY){
	$startDate = new DateTime();
	$startDate->setDate($sY, $sM, 1);

	$presentDate = new DateTime();

	$endDate = new DateTime();

	if( !($eM == "111" || $eY == "111") ){ // if NOT present
		$endDate->setDate($eY, $eM, 1);
	}
	

	if( $startDate > $endDate ){
		echo "Error: Starting Date is greater than the Ending Date.";
		exit;
	}
	if( $startDate > $presentDate || $endDate > $presentDate){
		echo "Error: Starting Date or Ending Date is greater than the Present Date";
		exit;
	}

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
    	$experience = new ParseObject("experience");
    	$experience->set("userProfile", $profile);
    	$experience->set("company", $company);
    	$experience->set("title", $title);
    	$experience->set("desc", $desc);
    	$experience->set("sM", rMon($sM) );
    	$experience->set("sY", $sY);
    	$experience->set("sortBy", $endDate );
    	if($endDate == $presentDate){
    		$experience->set("eM", "Present");
    		$experience->set("eY", " ");
    	}else{
    		$experience->set("eM", rMon($eM) );
    		$experience->set("eY", $eY);
    	}

    	$interval = $startDate->diff($endDate);
    	$y = $interval->format('%y');
    	$m = $interval->format('%m');

    	$diff = ( $y * 12 ) + $m;

    	$experience->set("diffMonths", $diff );
    	//$experience->set("diffDisplay", diffDisplay($interval) );

    	$experience->save(true);

    	$experienceList = $profile->getRelation("experienceList");
    	$experienceList->add($experience);
    	$profile->save(true);

    } catch (ParseException $ex) {
    	echo $ex->getMessage().".<br>";
    }
    header("Location: edit_experience.php");
    exit;
} // end of AddExperience

function rMon($mon){
	if($mon == "01") return "Jan";
	if($mon == "02") return "Feb";
	if($mon == "03") return "Mar";
	if($mon == "04") return "Apr";
	if($mon == "05") return "May";
	if($mon == "06") return "Jun";
	if($mon == "07") return "Jul";
	if($mon == "08") return "Aug";
	if($mon == "09") return "Sep";
	if($mon == "10") return "Oct";
	if($mon == "11") return "Nov";
	if($mon == "12") return "Dec";
}

function diffDisplay($interval){
	$m = $interval->format('%m');
		if($m > 12){
			return $interval->format('%y Years and %m Months experience');
		}else{
			return $interval->format('%m Months experience');
		}
}

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


function displayExperience($currentUser){
	$currentUser->fetch();

	$profile = $currentUser->get("profile");
	$profile->fetch();

	$experienceList = $profile->getRelation("experienceList")->getQuery()->descending("sortBy")->find();

	if($experienceList){
		foreach($experienceList as $x){
			$x->fetch();
			?>
			<div class="row">
				<div class="col-md-3">
					<?php echo $x->get("sM") . " " . $x->get("sY") . " - " . $x->get("eM") . " " . $x->get("eY"); ?>
				</div>
				<div class="col-md-9">
					<?php
					echo "<b>".$x->get("title") . ", ". $x->get("company")."</b><br>";
					echo $x->get("desc");
					?>
				</div>
			</div>
			<?php 
		}
	}
}

function displayEducation($currentUser){
	$currentUser->fetch();

	$profile = $currentUser->get("profile");
	$profile->fetch();

	$educationList = $profile->getRelation("educationList")->getQuery()->descending("gradYear")->find();

	if($educationList){
		foreach($educationList as $x){
			$x->fetch();
			?>
			<div class="row">
				<div class="col-md-3">
					<?php echo "Graduated ".$x->get("gradYear"); ?>
				</div>
				<div class="col-md-9">
					<?php
					echo "<b>".$x->get("degree") ."</b><br>";
					echo $x->get("school");
					?>
				</div>
			</div>
			<?php 
		}
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

	addExperience($currentUser, $company, $title, $desc, $sM, $sY, $eM, $eY);
}
?>