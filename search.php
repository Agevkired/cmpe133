<?php
require 'auth.php';

use Parse\ParseUser;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseException;
/*
function search($searchString){
    $arr = array();
    
    try{
        $query = ParseUser::query();//exists("Profile")
        $results = $query->ascending("name")->find();
        echo count($results);
        foreach($results as $user){
            $arr[] = array('id' => $obj->ID, 'title' => $obj->post_title);
            echo $user->getObjectId() . " - " . $user->get('name') . " - " . $user->getEmail(). "<br>";
        }

    } catch (ParseException $ex) {
        
    }
    echo json_encode($arr);

*/
$arr = array();

if(isset($_POST["keywords"])) {
    $keywords = "/".$_POST['keywords']."/i";
    try{
        $query = ParseUser::query();//exists("Profile")
        $results = $query->ascending("name")->find();
        //echo count($results);
        foreach($results as $user){
            $string = $user->get('name')." ".$user->getEmail();
            if( preg_match( $keywords, $string )){
                $arr[] = array('id' => $user->getObjectId(), 'name' => $user->get('name'), 'email' => $user->getEmail());
            }
        }

    } catch (ParseException $ex) {
         
    }
    echo json_encode($arr);

}

if(isset($_POST["allForums"])) {
        
    try{
        $query = ParseUser::query();//exists("Profile")
        $results = $query->ascending("name")->find();
        //echo count($results);
        foreach($results as $user){
            $string = $user->get('name')." ".$user->getEmail();
            
                $arr[] = array('id' => $user->getObjectId(), 'name' => $user->get('name'), 'email' => $user->getEmail());
            
        }

    } catch (ParseException $ex) {
         
    }
    echo json_encode($arr);
}

?>
