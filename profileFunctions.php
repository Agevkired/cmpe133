<?php
require 'auth.php';

use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseException;

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

function createNewForumRoot($currentUser, $title, $content, $searchTagString){
$searchTagString = trim(strtolower($searchTagString));

	try {
		$forumPost = new ParseObject("forumPost");
		$forumPost->set("createdBy", $currentUser);
		$forumPost->set("content", $content);
		$forumPost->save(true);
		echo "<br>successfully created forumPost object<br>";//debugging
	} catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }


    try {
        $forumRoot = new ParseObject("forumRoot");
        $forumRoot->set("createdBy", $currentUser); //pointer profile->user
        $forumRoot->set("lastUpdatedBy", $currentUser);
        $forumRoot->set("createdBy", $currentUser);
        $forumRoot->set("postCount", 1);
        $forumRoot->set("title", $title);
        $forumRoot->set("searchTags", $searchTagString);
        $forumRoot->addUnique("forumPost", [$forumPost]);
        $forumRoot->save(true);

        echo "<br>successfully created forumRoot object<br>";//debugging
    } catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }


}
/*
function createEducation($currentUser, $school, $degree, $gradyear){

	try {
		$forumPost = new ParseObject("education");
		$forumPost->set("userPointer", $currentUser);
		$forumPost->set("school", $school);
		$forumPost->set("degree", $degree);
		$forumPost->set("gradyear", $gradyear);
		$forumPost->save(true);
		echo "<br>successfully created forumPost object<br>";//debugging
	} catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }



    try {
	    $forumRoot = new ParseQuery("forumRoot");
	    $forumRoot->equalTo("objectId", $forumRootObjectId );
	    $forumRoot = $forumRoot->first();
	    $forumRoot->fetch();
	    $forumRoot->addUnique("forumPost", [$forumPost]);
        $forumRoot->save(true);

        echo "<br>successfully created forumRoot->forumPost object<br>";//debugging
	} catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }

}*/

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

function displayForumRoot($forumRootObjectId){
	$forumRoot = new ParseQuery("forumRoot");
    $forumRoot->equalTo("objectId", $forumRootObjectId );
    $forumRoot = $forumRoot->first();
    $forumRoot->fetch();


    echo "--------------------<br>";
    echo $forumRoot->get("title")."<br>";
    echo "--------------------<br>";
	$forumPostsArray = $forumRoot->get("forumPost");
	foreach($forumPostsArray as $forumPost){
		$forumPost->fetch();
		$createdBy = $forumPost->get("createdBy");
		$createdBy->fetch();

		echo $createdBy->get("name") . ": " .  $forumPost->get("content") . "<br>";
	}
}

	
$arr = array();





//if(isset($_POST["allForums"])) {
function forumDisplay(){
    try{

		$forumRoot = new ParseQuery("forumRoot");
	    $forumTrees = $forumRoot->descending("updatedAt")->find();

	    foreach($forumTrees as $forumRoot){
	    	$createdBy = $forumRoot->get("createdBy");
			$createdBy->fetch();

			$arr[] = array('id' => $forumRoot->getObjectId(),
				'title' => $forumRoot->get("title"),
				'createdBy' => $createdBy->get("name"),
				'createdAt' => $forumRoot->getCreatedAt()->format('M d,Y, g:ia') ." UTC",
				'updatedAt' => $forumRoot->getUpdatedAt()->format('M d,Y, g:ia') ." UTC");

    		echo $forumRoot->get("title"). " BY: " . $createdBy->get("name") . " last updated: " . $forumRoot->getUpdatedAt()->format('M d,Y, g:ia') ." UTC<br>";
	    }

    } catch (ParseException $ex) {
         
    }
    echo json_encode($arr);
}



if(isset($_POST["allForums"])) {
   try{

		$forumRoot = new ParseQuery("forumRoot");
	    $forumTrees = $forumRoot->descending("updatedAt")->find();

	    foreach($forumTrees as $forumRoot){
	    	$createdBy = $forumRoot->get("createdBy");
			$createdBy->fetch();

			$arr[] = array('id' => $forumRoot->getObjectId(),
				'title' => $forumRoot->get("title"),
				'createdBy' => $createdBy->get("name"),
				'createdAt' => $forumRoot->getCreatedAt()->format('M d,Y, g:ia') ." UTC",
				'updatedAt' => $forumRoot->getUpdatedAt()->format('M d,Y, g:ia') ." UTC");
	    }

    } catch (ParseException $ex) {
         
    }
    echo json_encode($arr);
}



if(isset($_POST["keywords"])) {
    $keywords = "/".$_POST['keywords']."/i";
    try{

        $forumRoot = new ParseQuery("forumRoot");
	    $forumTrees = $forumRoot->descending("updatedAt")->find();

    	foreach($forumTrees as $forumRoot){
	    	$createdBy = $forumRoot->get("createdBy");
			$createdBy->fetch();
			$string = $forumRoot->get("title") . " " . $createdBy->get("name") . " " . $createdBy->get("email");
			if( preg_match( $keywords, $string )){
			$arr[] = array('id' => $forumRoot->getObjectId(),
				'title' => $forumRoot->get("title"),
				'createdBy' => $createdBy->get("name"),
				'createdAt' => $forumRoot->getCreatedAt()->format('M d,Y, g:ia') ." UTC",
				'updatedAt' => $forumRoot->getUpdatedAt()->format('M d,Y, g:ia') ." UTC");
	    	}
	    }


    } catch (ParseException $ex) {
         
    }
    echo json_encode($arr);

}
?>