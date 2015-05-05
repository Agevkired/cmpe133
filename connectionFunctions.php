<?php
require 'auth.php';

use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseException;
use Parse\ParseRelation;

ob_start(); 
if (!session_id()) session_start();

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


function createConnectionRequest( $currentUser, $friendsId ){

    /* START OF FIND CONNECTION */
    $query = ParseUser::query();
    $query->equalTo("objectId", $friendsId); 
    $friend = $query->first(); // only get first result
    //echo "Successfully retrieved " . count($friend) . " results.<br>";// debugging
    //echo $friend->get("name")."<br>"; // debugging

    $checkConnectionRequest = new ParseQuery("connectionRequest");
    $currentUser->fetch();
    if($currentUser->getObjectId() == $friend->getObjectId()){
        echo "You can't connect to yourself silly.<br>";
        return;
    }


    $alreadyConnected = $currentUser->getRelation("connections")->getQuery()->equalTo("objectId", $friendsId )->first();
    if($alreadyConnected){
        echo "Your already connected to <br>".$friend->get("name")."<br>";
        return;
    }

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
            echo "Connection request sent to <br>". $friend->get("name").".<br>";

        } catch (ParseException $ex) {
            echo $ex->getMessage().".<br>";
        }
    }else{
        echo "You currently have a pending connection request with ". $friend->get("name").".<br>";
    }
    
    /* END OF CONNECTION REQUEST */

}





function seeConnectionRequest($currentUser){
    
    /* START OF REQUESTED ME */
        
    $queryReqMe = new ParseQuery("connectionRequest");
    $currentUser->fetch();
    $queryReqMe->equalTo("toUser", $currentUser );
    $results = $queryReqMe->find();
    //echo "People who requested me: " .count($results). "<br>";
?>
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">

                <div class="panel panel-default">
                <div class="panel-heading"><strong>Pending Connections</strong></div>
                <div class="panel-body">
<?php
    foreach($results as $connectionRequest){
        $friend = $connectionRequest->get("fromUser");
        $friend->fetch();

        $name = $friend->get("name");
        $email = $friend->get("email");


        ?>                  
        <div class="row">
            <div class="col-md-6">
                <h4><?php echo $name ?></br><small><?php echo $email ?></h4>
                <!--<div class="profile-usertitle-name">Tomas Verga</div>
                <div class="profile-usertitle-job">vergaGrande12@yahoo.com</div>-->
            </div>
            <div class="col-md-3">
                <button type="button" onclick="parent.location='connectionFunctions.php?acceptRequest=<?php echo $connectionRequest->getObjectId() ?>'" class="btn btn-primary">Accept Request</button>
            </div>
            <div class="col-md-3">
                <button type="button" onclick="parent.location='connectionFunctions.php?denyRequest=<?php echo $connectionRequest->getObjectId() ?>'" class="btn btn-inverse">Deny Request</button>
            </div>
        </div> 
        <?php
    }

    /* END OF REQUESTED ME */


    /* START OF SEE CONNECTION USER REQUESTED */
    $queryIreq = new ParseQuery("connectionRequest");
    $currentUser->fetch();
    $queryIreq->equalTo("fromUser", $currentUser );
    $results = $queryIreq->find();
    //echo "People I requested: " .count($results). "<br>";
    foreach($results as $connectionRequest){
        $friend = $connectionRequest->get("toUser");
        $friend->fetch();

        //$fNameAndEmail = "<b>".$friend->get("name")."</b>, ".$friend->get("email");
        $name = $friend->get("name");
        $email = $friend->get("email");


        ?>                  
        <div class="row">
            <div class="col-md-6">
                <h4><?php echo $name ?></br><small><?php echo $email ?></h4>
                <!--<div class="profile-usertitle-name">Tomas Verga</div>
                <div class="profile-usertitle-job">vergaGrande12@yahoo.com</div>-->
            </div>
            <div class="col-md-3">
                <button type="button"  class="btn btn-default">Request Sent</button>
            </div>
            <div class="col-md-3">
                <button type="button" onclick="parent.location='connectionFunctions.php?denyRequest=<?php echo $connectionRequest->getObjectId() ?>'" class="btn btn-inverse">Deny Request</button>
            </div>
        </div>        
        <?php
        
    }
    /* END OF SEE CONNECTION USER REQUESTED */
?>
                </div>
                </div>
                

<?php
}//end of seeConnectionRequest

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
        
        //echo "<br>START of CONNECTIONS<br><br>";
        //echo "Connections: " .count($currentUserConnections). "<br>";
        ?>

                <div class="panel panel-default">
                <div class="panel-heading"><strong>Connections</strong></div>
                <div class="panel-body">
        <?php

        if($currentUserConnections){
            foreach($currentUserConnections as $friend){
                $friend->fetch();
                //echo var_dump($friend);
                $name = $friend->get("name");
                $email = $friend->get("email");

                $profile = $friend->get("profile");

                $title = "";
                $location = "";
                if($profile){
                    $profile->fetch();
                    $title = $profile->get("currentTitle");
                    $location = $profile->get("currentLocale").", ".$profile->get("currentState");
                }

                ?>
                <div class="row">
                    <div class="col-md-5">
                        <h4><?php echo $name ?></br><small><?php echo $email ?></h4>
                        <!--<div class="profile-usertitle-name">Tomas Verga</div>
                        <div class="profile-usertitle-job">vergaGrande12@yahoo.com</div>-->
                    </div>
                    <div class="col-md-4">
                        <h4><?php echo $title ?></br><small><?php echo $location ?></small></h4>
                    </div>
                    <div class="col-md-3">
                        <button type="button" onclick="parent.location='connectionFunctions.php?disconnect=<?php echo $currentUser->getObjectId()."-". $friend->getObjectId() ?>'" class="btn btn-inverse">Disconnect</button>
                    </div>
                </div>
                <?php
            }
        }
        ?>

                        </div>
                </div>
                
            </div>
        </div>  
    </div>
    <?php



    } catch (ParseException $ex) {
        echo $ex->getMessage().".<br>";
    }
}



function destroyConnection($currentUserId, $unfriendId){
    try{
    $query = ParseUser::query();
    $unfriend = $query->equalTo("objectId", $unfriendId)->first();
    $currentUser = $query->equalTo("objectId", $currentUserId)->first();

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

if(isset($_GET["denyRequest"])) {
    $id = $_GET["denyRequest"];
    $query = new ParseQuery("connectionRequest");
    try{
        $experience = $query->equalTo("objectId", $id )->first();

        if($experience){
            $experience->destroy(true);
        }
    }catch (ParseException $ex) {
            
    }
    header("Location: view_connections.php");
    exit;
}

if(isset($_GET["acceptRequest"])) {
    $id = $_GET["acceptRequest"];
    $query = new ParseQuery("connectionRequest");
    try{
        $experience = $query->equalTo("objectId", $id )->first();

        if($experience){
            acceptConnectionRequest($experience);
        }
    }catch (ParseException $ex) {
            
    }
    header("Location: view_connections.php");
    exit;
}

if(isset($_GET["disconnect"])) {
    $disconnect = $_GET["disconnect"];
    $pieces = explode("-", $disconnect);
    echo $pieces[0]; // piece1
    echo $pieces[1]; // piece2
    
    destroyConnection($pieces[0], $pieces[1]);

    header("Location: view_connections.php");
    exit;
}
?>