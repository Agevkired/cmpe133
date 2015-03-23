<?php
use Parse\ParseObject;
use Parse\ParseUser;
use Parse\ParseException;

function msgr($currentUser){
    
    // Create the post
    /*
    $myPost = new ParseObject("Post");
    $myPost->set("title", "I'm Hungry");
    $myPost->set("content", "Where should we go for lunch?");
    
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
        $currentUser->set("msgTest", $myPost );
        $currentUser->save(true);
      // The current user is now set to user.
    } catch (ParseException $ex) {
      // The token could not be validated.
        echo $ex->getMessage().".<br>";
    }*/
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
    }
}

?>