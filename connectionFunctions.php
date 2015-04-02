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


function createConnectionRequest( $currentUser, $friendsEmail ){

    /* START OF FIND CONNECTION */
    $query = ParseUser::query();
    $query->equalTo("email", $friendsEmail); 
    $friend = $query->first(); // only get first result
    echo "Successfully retrieved " . count($friend) . " results.<br>";// debugging
    echo $friend->get("name")."<br>"; // debugging

    $checkConnectionRequest = new ParseQuery("connectionRequest");
    $currentUser->fetch();
    $checkConnectionRequest = $checkConnectionRequest->equalTo("fromUser", $currentUser )->equalTo("toUser", $friend );

    /* END OF FINDING CONNECTION */


    /* START OF CONNECTION REQUEST */

    /* IF CONNECTION REQUEST DOESN'T ALREADY EXIST */
    if( !$checkConnectionRequest->find(true) ){
        try {

            /* IF THEY ARE NOT CONNECTED ALREADY
            $currentUserProfile = $currentUser->get("Profile");
            $currentUserProfile->fetch();
            $currentUserConnections =  $currentUserProfile->get("connections");
            */

            $connectionRequest = new ParseObject("connectionRequest");
            $connectionRequest->set("fromUser", $currentUser);
            $connectionRequest->set("toUser", $friend);
            // user2Accepts is left undefined until user2 accepts or denys
            $connectionRequest->save(true);
            echo "successfully created connectionRequest<br>";

        } catch (ParseException $ex) {
            echo $ex->getMessage().".<br>";
        }
    }else{
        echo "You already have a pending connection request with ". $friend->get("name")."<br>";
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
    foreach($results as $connectionRequest){
        $friend = $connectionRequest->get("user2");
        $friend->fetch();
        echo $friend->get("name").", ";
        $friendProfile = $friend->get("Profile");
        $friendProfile->fetch();
        echo $friendProfile->get("currentPosition").", ";
        echo $friendProfile->get("city").", ";
        echo $friendProfile->get("state")."<br>";

        
    }
    /* END OF SEE CONNECTION USER REQUESTED */


    /* START OF SEE CONNECTION USER REQUESTED */
        
    $queryReqMe = new ParseQuery("connectionRequest");
    $currentUser->fetch();
    $queryReqMe->equalTo("user2", $currentUser );
    $results = $queryReqMe->find();
    echo "People who requested me: " .count($results). "<br>";
    foreach($results as $connectionRequest){
        $friend = $connectionRequest->get("user1");
        $friend->fetch();
        echo $friend->get("name").", ";
        $friendProfile = $friend->get("Profile");
        $friendProfile->fetch();
        echo $friendProfile->get("currentPosition").", ";
        echo $friendProfile->get("city").", ";
        echo $friendProfile->get("state")."<br>";
        acceptConnectionRequest( $connectionRequest );// testing
    }

    /* END OF SEE CONNECTION USER REQUESTED */
    echo "<br>END of seeConnectionRequest<br>"; //debugging


}

function acceptConnectionRequest($connectionRequestObject){

    echo "<br>START of acceptConnectionRequest<br><br>"; //debugging
    try {
        $user1 = $connectionRequestObject->get("user1");
        $user1->fetch();
        $user1profile = $user1->get("Profile");
        $user1profile->fetch();

        $user2 = $connectionRequestObject->get("user2");
        $user2->fetch();
        $user2profile = $user2->get("Profile");
        $user2profile->fetch();

        $user1profile->addUnique("connections", [$user2]);
        $user1profile->save(true);

        $user2profile->addUnique("connections", [$user1]);
        $user2profile->save(true);

        echo $user1->get("name") . " is now friends with " . $user2->get("name"). "<br>";

        $connectionRequestObject->destroy(true);

    } catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }
    echo "<br>END of acceptConnectionRequest<br><br>"; //debugging
}

function displayConnections($currentUser){

    try{
        $currentUserProfile = $currentUser->get("Profile");
        $currentUserProfile->fetch();

        $currentUserConnections =  $currentUserProfile->get("connections");
        echo "<br>START of CONNECTIONS<br><br>";
        echo "Connections: " .count($currentUserConnections). "<br>";
        if($currentUserConnections){
            foreach($currentUserConnections as $friend){
                $friend->fetch();
                echo $friend->get("name").", ";
                $friendProfile = $friend->get("Profile");
                $friendProfile->fetch();
                echo $friendProfile->get("currentPosition").", ";
                echo $friendProfile->get("city").", ";
                echo $friendProfile->get("state")."<br>";
            }
        }
        echo "<br>END of CONNECTIONS<br><br>";

    } catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }
}


?>