<?php
    /**
    * ProConnect
    * index.php
    * Login Page
    */

    /* auth.php CONTAINS PARSE DATABASE AUTHENTICATION SECRET KEYS */
    require 'auth.php';

    /* Parse Dependencies */
    use Parse\ParseUser;
    use Parse\ParseException;
    use Parse\ParseQuery;

  





    


    /* IF LOGIN POST TRIGGERED */
    if(isset($_POST["id"])) {
        $id = $_POST["id"];
        $connectionRequestObject = new ParseQuery("connectionRequest");
        $connectionRequestObject->fetch();
        $connectionRequestObject->equalTo("objectId", $id );
        $results = $queryReqMe->find();
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
    

?>
