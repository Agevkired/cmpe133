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
 
        $name = $user->get("name");
        $email = $user->get("email");
        $title = $user->get("currentTitle");
        $location = $user->get("currentLocale").", ".$user->get("currentState");

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
                <button type="button" onclick="parent.location='view_profile.php?code=<?php echo $id ?>'" class="btn btn-primary">View Profile</button>
            </div>
        </div>
                <?php
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
      <?php echo stateOptionPrint() ?>
    </select>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="premiumSearch"></label>
  <div class="col-md-4">
    <button id="premiumSearch" name="premiumSearch" class="btn btn-primary">Search Connections</button>
  </div>
</div>

</fieldset>
</form>


</div>
</div>


<?php
} // end of premiumMain

function stateOptionPrint(){ ?>
    <option value="AL">Alabama</option>
    <option value="AK">Alaska</option>
    <option value="AZ">Arizona</option>
    <option value="AR">Arkansas</option>
    <option value="CA">California</option>
    <option value="CO">Colorado</option>
    <option value="CT">Connecticut</option>
    <option value="DE">Delaware</option>
    <option value="DC">District Of Columbia</option>
    <option value="FL">Florida</option>
    <option value="GA">Georgia</option>
    <option value="HI">Hawaii</option>
    <option value="ID">Idaho</option>
    <option value="IL">Illinois</option>
    <option value="IN">Indiana</option>
    <option value="IA">Iowa</option>
    <option value="KS">Kansas</option>
    <option value="KY">Kentucky</option>
    <option value="LA">Louisiana</option>
    <option value="ME">Maine</option>
    <option value="MD">Maryland</option>
    <option value="MA">Massachusetts</option>
    <option value="MI">Michigan</option>
    <option value="MN">Minnesota</option>
    <option value="MS">Mississippi</option>
    <option value="MO">Missouri</option>
    <option value="MT">Montana</option>
    <option value="NE">Nebraska</option>
    <option value="NV">Nevada</option>
    <option value="NH">New Hampshire</option>
    <option value="NJ">New Jersey</option>
    <option value="NM">New Mexico</option>
    <option value="NY">New York</option>
    <option value="NC">North Carolina</option>
    <option value="ND">North Dakota</option>
    <option value="OH">Ohio</option>
    <option value="OK">Oklahoma</option>
    <option value="OR">Oregon</option>
    <option value="PA">Pennsylvania</option>
    <option value="RI">Rhode Island</option>
    <option value="SC">South Carolina</option>
    <option value="SD">South Dakota</option>
    <option value="TN">Tennessee</option>
    <option value="TX">Texas</option>
    <option value="UT">Utah</option>
    <option value="VT">Vermont</option>
    <option value="VA">Virginia</option>
    <option value="WA">Washington</option>
    <option value="WV">West Virginia</option>
    <option value="WI">Wisconsin</option>
    <option value="WY">Wyoming</option>
<?php 
} // end of stateOptionPrint

?>