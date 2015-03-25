<?php
use Parse\ParseObject;
use Parse\ParseUser;
use Parse\ParseException;

function createProfile($currentUser){
    
    /* START CREATE PROFILE OBJECT */
    try {
        $profile = new ParseObject("Profile");
        $profile->set("User", $currentUser); //pointer profile->user
        $profile->set("currentPosition", "Software Engineer");
        $profile->set("city", "San Jose");
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


function createConnectionRequest($currentUser){
    $query = ParseUser::query();
    $query->equalTo("name", "Dan"); 
    $results = $query->find();
    print_r($results);
    /*
    try {
        $connectionRequest = new ParseObject("connectionRequest");

    } catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }*/

}



    /*
    // Create the comment
    $myComment = new ParseObject("Comment");
    
    $myComment->set("content", "Let's do Sushirrito.");
     
    // Add the post as a value in the comment
    $myPost->set("child", $myComment);
    $myPost->save();
    $myComment->set("parent", $myPost);
     
    // This will save both myPost and myComment
    $myComment->save();


    try {
        $currentUser->set("profile", $profile );
        $currentUser->save(true);
      // The current user is now set to user.
    } catch (ParseException $ex) {
      // The token could not be validated.
        echo $ex->getMessage().".<br>";
    }


    try {

    } catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }

    echo "Authenticated: ".$currentUser->isAuthenticated()."<br>";//debugging
    try {
        $currentUser->fetch();
        $post = $currentUser->get("msgTest");
        $post->fetch();
        //var_dump($post);
        echo $post->get("title")."<br>";
        echo $post->get("content")."<br>";
        $post = $post->get("child");
        $post->fetch();
        echo $post->get("content")."<br>";
        
        //The object was retrieved successfully.
    } catch (ParseException $ex) {
        // The object was not retrieved successfully.
        // error is a ParseException with an error code and message.
        echo $ex->getMessage().".<br>";
    }*/


?>