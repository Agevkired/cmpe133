<?php
    /**
    * ProConnect
    * android.php
    * Android Client Master Key Cloud Code
    */

    /* auth.php CONTAINS PARSE DATABASE AUTHENTICATION SECRET KEYS */
    require 'auth.php';

    /* Parse Dependencies */
    use Parse\ParseUser;
    use Parse\ParseException;
    use Parse\ParseQuery;


    /*
    Accept Connection Request
    @param crid = connectionRequest->ObjectId
    */
    if(isset($_POST["crid"])) {
        $id = $_POST["crid"];

        $connectionRequestObject = new ParseQuery("connectionRequest");

        $connectionRequestObject->equalTo("objectId", $id );
        $connectionRequestObject = $connectionRequestObject->first();
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

            

            $connectionRequestObject->destroy(true);

            //success message//
            echo $user1->get("name") . " is now connected with " . $user2->get("name");


        } catch (ParseException $ex) {

            echo $ex->getMessage().".<br>";
        }

    }

    /*
    Remove Friend Connection from connections Relation
    @param cuid = currentUser->ObjectId
    @param ufid = unFriend->ObjectId
    */
    if(isset($_POST["cuid"]) && isset($_POST["ufid"])) {
        $currentUserId = $_POST["cuid"];
        $unfriendId = $_POST["ufid"];
        try{
        $query = ParseUser::query();
        $unfriend = $query->equalTo("objectId", $unfriendId)->first();
        $currentUser = $query->equalTo("objectId", $currentUserId)->first();
        
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
