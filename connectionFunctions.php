<?php
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseException;
use Parse\ParseRelation;

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
    $queryIreq->equalTo("fromUser", $currentUser );
    $results = $queryIreq->find();
    echo "People I requested: " .count($results). "<br>";
    foreach($results as $connectionRequest){
        $friend = $connectionRequest->get("toUser");
        $friend->fetch();
        echo $friend->get("name").", ".$friend->get("email")."<br>";
        
    }
    /* END OF SEE CONNECTION USER REQUESTED */


    /* START OF SEE CONNECTION USER REQUESTED */
        
    $queryReqMe = new ParseQuery("connectionRequest");
    $currentUser->fetch();
    $queryReqMe->equalTo("toUser", $currentUser );
    $results = $queryReqMe->find();
    echo "People who requested me: " .count($results). "<br>";
    foreach($results as $connectionRequest){
        $friend = $connectionRequest->get("fromUser");
        $friend->fetch();
        echo $friend->get("name").", ".$friend->get("email");
        acceptConnectionRequest( $connectionRequest );// testing
    }

    /* END OF SEE CONNECTION USER REQUESTED */
    echo "<br>END of seeConnectionRequest<br>"; //debugging


}

function acceptConnectionRequest($connectionRequestObject){

    echo "<br>START of acceptConnectionRequest<br><br>"; //debugging
    try {
        $user1 = $connectionRequestObject->get("fromUser");
        $user1->fetch();
        $user1connect = $user1->getRelation("connections");


        $user2 = $connectionRequestObject->get("toUser");
        $user2->fetch();
        $user2connect = $user2->getRelation("connections");


        $user1connect->add($user2);
        $user1->save(true);

        $user2connect->add($user1);

        $user2->save(true);

        echo $user1->get("name") . " is now friends with " . $user2->get("name"). "<br>";

        $connectionRequestObject->destroy(true);

    } catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }
    echo "<br>END of acceptConnectionRequest<br><br>"; //debugging
}

function displayConnections($currentUser){

    try{

        $currentUserConnections =  $currentUser->getRelation("connections")->getQuery()->find();
        //echo var_dump($currentUserConnections);
        echo "<br>START of CONNECTIONS<br><br>";
        echo "Connections: " .count($currentUserConnections). "<br>";
        if($currentUserConnections){
            foreach($currentUserConnections as $friend){
                $friend->fetch();
                //echo var_dump($friend);
                echo $friend->get("name").", ".$friend->get("email")."<br>";
                //$friendProfile = $friend->get("Profile");
                //$friendProfile->fetch();
                //echo $friendProfile->get("currentPosition").", ";
                //echo $friendProfile->get("city").", ";
                //echo $friendProfile->get("state")."<br>";
            }
        }
        echo "<br>END of CONNECTIONS<br><br>";

    } catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }
}



function destroyConnection($currentUser, $unfriendId){
    try{
    $query = ParseUser::query();
    $unfriend = $query->equalTo("objectId", $unfriendId)->first();

    //$unfriend = $query->first(); // only get first result
    //echo "Successfully retrieved " . count($unfriend) . " results.<br>";// debugging
    //echo $unfriend->get("name")."<br>"; // debugging
    
    $currentUser->getRelation("connections")->remove($unfriend);
    $currentUser->save(true);

    $unfriend->getRelation("connections")->remove($currentUser);
    $unfriend->save(true);

    echo "You are no longer connected to ".$unfriend->get("name");

    } catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }
}


?>