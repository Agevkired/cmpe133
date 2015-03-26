<?php
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

    /* START OF FIND CONNECTION */
    $query = ParseUser::query();
    $query->equalTo("email", "emendoza1986@gmail.com"); 
    $results = $query->first(); // only get first result
    echo "Successfully retrieved " . count($results) . " results.<br>";// debugging
    echo $results->get("name")."<br>"; // debugging


    /* END OF FINDING CONNECTION */


    /* START OF CONNECTION REQUEST */
    
    try {
        $connectionRequest = new ParseObject("connectionRequest");
        $connectionRequest->set("user1", $currentUser);
        $connectionRequest->set("user2", $results);
        $connectionRequest->set("user1Accepts",true);
        // user2Accepts is left undefined until user2 accepts or denys
        $connectionRequest->save(true);
        echo "successfully created connectionRequest<br>";

    } catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }
    
    /* END OF CONNECTION REQUEST */

}

function seeConnectionRequest($currentUser){
    echo "<br>START of seeConnectionRequest<br><br>"; //debugging

    /* START OF SEE CONNECTION USER REQUESTED */
    $queryIreq = new ParseQuery("connectionRequest");
    $currentUser->fetch();
    $queryIreq->equalTo("user1", $currentUser );
    $results = $queryIreq->find();
    echo "People I requested: " .count($results). "<br>";
    foreach($results as $object){
        $object = $object->get("user2");
        $object->fetch();
        echo $object->get("name").", ";
        $object = $object->get("Profile");
        $object->fetch();
        echo $object->get("currentPosition").", ";
        echo $object->get("city").", ";
        echo $object->get("state")."<br>";
    }
    /* END OF SEE CONNECTION USER REQUESTED */


    /* START OF SEE CONNECTION USER REQUESTED */
        
    $queryReqMe = new ParseQuery("connectionRequest");
    $currentUser->fetch();
    $queryReqMe->equalTo("user2", $currentUser );
    $results = $queryReqMe->find();
    echo "People who requested me: " .count($results). "<br>";
    foreach($results as $object){
        $object = $object->get("user1");
        $object->fetch();
        echo $object->get("name")."<br>";
        $object = $object->get("Profile");
        $object->fetch();
        echo $object->get("currentPosition").", ";
        echo $object->get("city").", ";
        echo $object->get("state")."<br>";
    }

    /* END OF SEE CONNECTION USER REQUESTED */
    echo "<br>END of seeConnectionRequest<br>"; //debugging


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