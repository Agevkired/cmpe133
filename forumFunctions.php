<?php

use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseException;


function createNewForumRoot($currentUser, $title, $content, $searchTagString){
$searchTagString = strtolower($searchTagString);
$searchTagArray = explode(",", $searchTagString); //string to array comma delimiter
$searchTagArray = array_map('trim',$searchTagArray); // removes excess white spaces from front and end

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
        $forumRoot->set("title", $title);
        $forumRoot->setArray("searchTags", $searchTagArray);
        $forumRoot->addUnique("forumPost", [$forumPost]);
        $forumRoot->save(true);

        echo "<br>successfully created forumRoot object<br>";//debugging
    } catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }


}

function createForumPost($forumRootObjectId,$currentUser,$content){

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

function forumSearch($searchString){
	$searchString = strtolower($searchString);
	$searchString = trim($searchString);
	$searchTagArray = explode(" ", $searchString); //string to array whitespace delimiter

}
	

?>