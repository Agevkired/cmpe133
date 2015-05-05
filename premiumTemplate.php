<?php
	require 'auth.php';
    use Parse\ParseUser;
    use Parse\ParseQuery;
    use Parse\ParseObject;
    use Parse\ParseException;

ob_start(); 
if (!session_id()) session_start();

function printfn($result){
	if($result){
		$query = new ParseQuery("profile");
		foreach($result as $id){

        	$user = $query->equalTo("objectId", $id)->first();
 
			echo $user->get("name")." ".$id."<br>";
		}
	}

}

function premiumMain($currentUser, $results){
    $premium = $currentUser->get("premium");

    if(!$premium){
      	header("Location: profile.php");
    	exit;  
    }
    // START OF HTML CODE
    ?>
        <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
  
                <div class="panel panel-default">
                <div class="panel-heading"><strong>Connections</strong></div>
                <div class="panel-body">
                    <?php printfn($results) ?>
                </div>
                </div>
            </div>
        </div>

    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
  
<form class="form-horizontal" role="form" action="premium_search_connections.php" method="POST">
<fieldset>

<!-- Form Name -->
<legend>Search Connections</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="company">Company</label>  
  <div class="col-md-6">
  <input id="company" name="company" type="text" placeholder="example: Google" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="title">Title</label>  
  <div class="col-md-6">
  <input id="title" name="title" type="text" placeholder="example: Software Engineer" class="form-control input-md">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="years">Years Experience</label>
  <div class="col-md-2">
    <select id="years" name="years" class="form-control">
      <option value="0">0</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="months">Months Experience</label>
  <div class="col-md-2">
    <select id="months" name="months" class="form-control">
      <option value="0">0</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="education">Education</label>  
  <div class="col-md-6">
  <input id="education" name="education" type="text" placeholder="example: Bachelor of Science in Software Engineering" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="school">School</label>  
  <div class="col-md-6">
  <input id="school" name="school" type="text" placeholder="example: San Jose State University" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="locale">Locale</label>  
  <div class="col-md-6">
  <input id="locale" name="locale" type="text" placeholder="example: SF Bay Area" class="form-control input-md">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="state">State</label>
  <div class="col-md-4">
    <select id="state" name="state" class="form-control">
      <option value="CA">California</option>
    </select>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="premiumSearch"></label>
  <div class="col-md-4">
    <button id="premiumSearch" name="premiumSearch" class="btn btn-inverse">Search Connections</button>
  </div>
</div>

</fieldset>
</form>


</div>
</div>


<?php
} // end of premiumMain



?>