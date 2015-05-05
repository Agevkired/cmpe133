<?php
include "profileFunctions.php";

function profileMain($currentUser){ 


    $profile = $currentUser->get("profile");
    if($profile){
        $profile->fetch();
    }

    $name = $currentUser->get("name");
    $email = $currentUser->get("email");
    $summary = "You need to enter a summary.";
    $currentLocale = "";
    $currentState = "";

    if($profile){
        $summary = $profile->get("summary");
        $currentLocale = $profile->get("currentLocale");
        $currentState = $profile->get("currentState");
    }   
    
    ?>


    <div class="row">
    <div class="row profile">
        <div class="col-md-12">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="col-md-4"></div>
                <div class="col-md-4">
                <div class="profile-userpic">
                    <img src="img/profile-photo.jpg" class="img-responsive" alt="">
                </div>

                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">

                    <div>
                    <h4><?php echo $name ?></br><small><?php echo $email ?></small></h4>
                    <?php
                    if($currentLocale && $currentState){
                     echo $currentLocale. ", " . $currentState;
                    }
                      ?>
                    </div>
                    <br>
                </div>
                </div>

                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                    <center>
                    <div class="btn-group" role="group">
    
                        <button type="button" class="btn btn-default" style="width: 100px; " >View</button>
                        <button  onclick="parent.location='edit_profile.php'" class="btn btn-default" style="width: 110px; " >Edit</button>
    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
  
                <div class="panel panel-default">
                <div class="panel-heading"><strong>Summary</strong></div>
                <div class="panel-body">
                    <?php echo nl2br($summary) ?>
                </div>
                </div>

                <div class="panel panel-default">
                <div class="panel-heading"><strong>Education</strong></div>
                <div class="panel-body">
                    <?php displayEducation($currentUser) ?>
                </div>
                </div>
                
                <div class="panel panel-default">
                <div class="panel-heading"><strong>Experience</strong></div>
                <div class="panel-body">
                    <?php displayExperience($currentUser) ?>
                </div>
                </div>

                <div class="panel panel-default">
                <div class="panel-heading"><strong>Connections</strong></div>
                <div class="panel-body">
                    <?php displayProfileConnections($currentUser) ?>
                </div>
                </div>
                
            </div>
        </div>  
    </div>

<?php
} // profileMain

function viewProfileMain($profile){ 
    $current = $profile->get("user");
    $current->fetch();

    $profile = $profile;
    if($profile){
        $profile->fetch();
    }

    $name = $profile->get("name");
    $email = $profile->get("email");
    $summary = "You need to enter a summary.";
    $currentLocale = "";
    $currentState = "";

    if($profile){
        $summary = $profile->get("summary");
        $currentLocale = $profile->get("currentLocale");
        $currentState = $profile->get("currentState");
    }   
    
    ?>


    <div class="row">
    <div class="row profile">
        <div class="col-md-12">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="col-md-4"></div>
                <div class="col-md-4">
                <div class="profile-userpic">
                    <img src="img/profile-photo.jpg" class="img-responsive" alt="">
                </div>

                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">

                    <div>
                    <h4><?php echo $name ?></br><small><?php echo $email ?></small></h4>
                    <?php
                    if($currentLocale && $currentState){
                     echo $currentLocale. ", " . $currentState;
                    }
                      ?>
                    </div>
                    <br>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
  
                <div class="panel panel-default">
                <div class="panel-heading"><strong>Summary</strong></div>
                <div class="panel-body">
                    <?php echo nl2br($summary) ?>
                </div>
                </div>

                <div class="panel panel-default">
                <div class="panel-heading"><strong>Education</strong></div>
                <div class="panel-body">
                    <?php displayEducation($current) ?>
                </div>
                </div>
                
                <div class="panel panel-default">
                <div class="panel-heading"><strong>Experience</strong></div>
                <div class="panel-body">
                    <?php displayExperience($current) ?>
                </div>
                </div>

                <div class="panel panel-default">
                <div class="panel-heading"><strong>Connections</strong></div>
                <div class="panel-body">
                    <?php displayProfileConnectionsView($current)//displayProfileConnections($current) ?>
                </div>
                </div>
                
            </div>
        </div>  
    </div>

<?php
} // profileMain

function editProfileMain($currentUser){ 
    $currentUser->fetch();
    $profile = $currentUser->get("profile");
    if($profile){
        $profile->fetch();
    }

    $name = $currentUser->get("name");
    $email = $currentUser->get("email");
    $summary = "You need to enter a summary.";
    $currentLocale = "";
    $currentState = "";
    $currentTitle = "";

    if($profile){
        $summary = $profile->get("summary");
        $currentState = $profile->get("currentState");
        $currentLocale = $profile->get("currentLocale");
        $currentTitle = $profile->get("currentTitle");
    }   
    
    ?>


    <div class="row">
    <div class="row profile">
        <div class="col-md-12">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="col-md-4"></div>
                <div class="col-md-4">
                <div class="profile-userpic">
                    <img src="img/profile-photo.jpg" class="img-responsive" alt="">
                </div>

                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">

                    <div>
                    <h4><?php echo $name ?></br><small><?php echo $email ?></small></h4>
                    <?php
                    if($currentLocale && $currentState){
                     echo $currentLocale. ", " . $currentState;
                    }
                      ?>
                    </div>
                    <br>
                </div>
                </div>

                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                    <center>
                    <div class="btn-group" role="group">
    
                        <button onclick="parent.location='profile.php'" class="btn btn-default" style="width: 100px; " >View</button>
                        <button type="button" class="btn btn-default" style="width: 110px; " >Edit</button>
    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
  
<form class="form-horizontal" role="form" action="profileFunctions.php" method="POST">
<fieldset>

<!-- Form Name -->
<legend>Edit Profile</legend>

<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="filebutton">Profile Picture</label>
  <div class="col-md-6">
    <input id="filebutton" name="profilePicture" class="input-file" type="file">
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Current Title</label>  
  <div class="col-md-6">
  <input id="textinput" name="currentTitle" type="text" placeholder="example: Student" class="form-control input-md" value="<?php echo $currentTitle ?>" required>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Current Locale</label>  
  <div class="col-md-6">
  <input id="textinput" name="currentLocale" type="text" placeholder="example: SF Bay Area" class="form-control input-md" value="<?php echo $currentLocale ?>" required>
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Current State</label>
  <div class="col-md-4">
    <select id="selectbasic" name="currentState" class="form-control">
      <?php stateOptionPrint() ?>
    </select>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="textarea">Summary</label>
  <div class="col-md-7">                     
    <textarea class="form-control" id="textarea" name="summary" required><?php // echo $summary ?></textarea>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton">Edit Education</label>
  <div class="col-md-4">
    <button id="singlebutton" onclick="parent.location='edit_education.php'" class="btn btn-inverse">Edit</button>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton">Edit Experience</label>
  <div class="col-md-4">
    <button id="singlebutton" onclick="parent.location='edit_experience.php'" class="btn btn-inverse">Edit</button>
  </div>
</div>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="button1id"></label>
  <div class="col-md-4">
    <button id="button1id" name="editProfile" class="btn btn-primary">Save</button>
    <button id="button2id" onclick="parent.location='profile.php'" class="btn btn-warning">Cancel</button>
  </div>
</div>

</fieldset>
</form>
<legend></legend>
                
            </div>
        </div>  
    </div>

<?php
} // profileMain

function editEducationMain($currentUser){ 
    $currentUser->fetch();
    $profile = $currentUser->get("profile");
    if($profile){
        $profile->fetch();
    }

    $name = $currentUser->get("name");
    $email = $currentUser->get("email");
    $summary = "You need to enter a summary.";
    $currentLocale = "";
    $currentState = "";

    if($profile){

        $currentLocale = $profile->get("currentLocale");
        $currentState = $profile->get("currentState");
    }   
    
    ?>


    <div class="row">
    <div class="row profile">
        <div class="col-md-12">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="col-md-4"></div>
                <div class="col-md-4">
                <div class="profile-userpic">
                    <img src="img/profile-photo.jpg" class="img-responsive" alt="">
                </div>

                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">

                    <div>
                    <h4><?php echo $name ?></br><small><?php echo $email ?></small></h4>
                    <?php
                    if($currentLocale && $currentState){
                     echo $currentLocale. ", " . $currentState;
                    }
                      ?>
                    </div>
                    <br>
                </div>
                </div>

                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                    <center>
                    <div class="btn-group" role="group">
    
                        <button onclick="parent.location='profile.php'" class="btn btn-default" style="width: 100px; " >View</button>
                        <button  onclick="parent.location='edit_profile.php'" class="btn btn-default" style="width: 110px; " >Edit</button>
    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">

                <div class="panel panel-default">
                <div class="panel-heading"><strong>Education</strong></div>
                <div class="panel-body">
                    <?php displayEditEducation($currentUser) ?>
                </div>
                </div>
                
            </div>
        </div>  
    </div>


    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
    <form class="form-horizontal"  role="form" action="profileFunctions.php" method="POST">
<fieldset>

<!-- Form Name -->
<legend>Edit Education</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">School</label>  
  <div class="col-md-7">
  <input id="textinput" name="school" type="text" placeholder="example: San Jose State University" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Degree</label>  
  <div class="col-md-7">
  <input id="textinput" name="degree" type="text" placeholder="example: Bachelor of Science in Computer Science" class="form-control input-md">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Graduation Year</label>
  <div class="col-md-3">
    <select id="selectbasic" name="gradYear" class="form-control">
      <?php yearSelect() ?>
    </select>
  </div>
</div>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="button1id"></label>
  <div class="col-md-8">
    <button id="button1id" name="addEducation" class="btn btn-primary">Add</button>
    <button id="button2id" onclick="parent.location='profile.php'" name="button2id" class="btn btn-warning">Cancel</button>
  </div>
</div>

</fieldset>
</form>
<legend></legend>
            </div>
        </div>  
    </div>

<?php
} // editEducationMain


function editExperienceMain($currentUser){ 
    $currentUser->fetch();
    $profile = $currentUser->get("profile");
    if($profile){
        $profile->fetch();
    }

    $name = $currentUser->get("name");
    $email = $currentUser->get("email");

    $currentLocale = "";
    $currentState = "";

    if($profile){
        $summary = $profile->get("summary");
        $currentLocale = $profile->get("currentLocale");
        $currentState = $profile->get("currentState");
    }   
    
    ?>


    <div class="row">
    <div class="row profile">
        <div class="col-md-12">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="col-md-4"></div>
                <div class="col-md-4">
                <div class="profile-userpic">
                    <img src="img/profile-photo.jpg" class="img-responsive" alt="">
                </div>

                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">

                    <div>
                    <h4><?php echo $name ?></br><small><?php echo $email ?></small></h4>
                    <?php
                    if($currentLocale && $currentState){
                     echo $currentLocale. ", " . $currentState;
                    }
                      ?>
                    </div>
                    <br>
                </div>
                </div>

                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                    <center>
                    <div class="btn-group" role="group">
    
                        <button onclick="parent.location='profile.php'" class="btn btn-default" style="width: 100px; " >View</button>
                        <button  onclick="parent.location='edit_profile.php'" class="btn btn-default" style="width: 110px; " >Edit</button>
    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">

                <div class="panel panel-default">
                <div class="panel-heading"><strong>Experience</strong></div>
                <div class="panel-body">
                    <?php displayEditExperience($currentUser) ?>
                </div>
                </div>
                
            </div>
        </div>  
    </div>


    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
    <form class="form-horizontal" role="form" action="profileFunctions.php" method="POST">
<fieldset>

<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Edit Experience</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Company</label>  
  <div class="col-md-7">
  <input id="textinput" name="company" type="text" placeholder="example: Google" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Title</label>  
  <div class="col-md-7">
  <input id="textinput" name="title" type="text" placeholder="example: Software Engineer" class="form-control input-md">
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="textarea">Description</label>
  <div class="col-md-7">                     
    <textarea class="form-control" id="textarea" name="desc"></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Starting Month</label>
  <div class="col-md-4">
    <select id="selectbasic" name="sM" class="form-control">
      <?php monthSelect() ?>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Starting Year</label>
  <div class="col-md-4">
    <select id="selectbasic" name="sY" class="form-control">
      <?php yearSelect() ?>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Ending Month</label>
  <div class="col-md-4">
    <select id="selectbasic" name="eM" class="form-control">
        <option value="111">Present</option>
        <?php monthSelect() ?>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Ending Year</label>
  <div class="col-md-4">
    <select id="selectbasic" name="eY" class="form-control">
        <option value="111">Present</option>
        <?php yearSelect() ?>
    </select>
  </div>
</div>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="button1id"></label>
  <div class="col-md-8">
    <button id="button1id" name="addExperience" class="btn btn-primary">Add</button>
    <button id="button2id" onclick="parent.location='profile.php'" name="button2id" class="btn btn-warning">Cancel</button>
  </div>
</div>

</fieldset>
</form>

<legend></legend>
            </div>
        </div>  
    </div>

<?php
} // editExperienceMain

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

function yearSelect(){ ?>
    <option value="2015">2015</option>
    <option value="2014">2014</option>
    <option value="2013">2013</option>
    <option value="2012">2012</option>
    <option value="2011">2011</option>
    <option value="2010">2010</option>
    <option value="2009">2009</option>
    <option value="2008">2008</option>
    <option value="2007">2007</option>
    <option value="2006">2006</option>
    <option value="2005">2005</option>
    <option value="2004">2004</option>
    <option value="2003">2003</option>
    <option value="2002">2002</option>
    <option value="2001">2001</option>
    <option value="2000">2000</option>
    <option value="1999">1999</option>
    <option value="1998">1998</option>
    <option value="1997">1997</option>
    <option value="1996">1996</option>
    <option value="1995">1995</option>
    <option value="1994">1994</option>
    <option value="1993">1993</option>
    <option value="1992">1992</option>
    <option value="1991">1991</option>
    <option value="1990">1990</option>
    <option value="1989">1989</option>
    <option value="1988">1988</option>
    <option value="1987">1987</option>
    <option value="1986">1986</option>
    <option value="1985">1985</option>
    <option value="1984">1984</option>
    <option value="1983">1983</option>
    <option value="1982">1982</option>
    <option value="1981">1981</option>
    <option value="1980">1980</option>
    <option value="1979">1979</option>
    <option value="1978">1978</option>
    <option value="1977">1977</option>
    <option value="1976">1976</option>
    <option value="1975">1975</option>
    <option value="1974">1974</option>
    <option value="1973">1973</option>
    <option value="1972">1972</option>
    <option value="1971">1971</option>
    <option value="1970">1970</option>
    <option value="1969">1969</option>
    <option value="1968">1968</option>
    <option value="1967">1967</option>
    <option value="1966">1966</option>
    <option value="1965">1965</option>
    <option value="1964">1964</option>
    <option value="1963">1963</option>
    <option value="1962">1962</option>
    <option value="1961">1961</option>
    <option value="1960">1960</option>
    <option value="1959">1959</option>
    <option value="1958">1958</option>
    <option value="1957">1957</option>
    <option value="1956">1956</option>
    <option value="1955">1955</option>
    <option value="1954">1954</option>
    <option value="1953">1953</option>
    <option value="1952">1952</option>
    <option value="1951">1951</option>
    <option value="1950">1950</option>
    <option value="1949">1949</option>
    <option value="1948">1948</option>
    <option value="1947">1947</option>
    <option value="1946">1946</option>
    <option value="1945">1945</option>
    <option value="1944">1944</option>
    <option value="1943">1943</option>
    <option value="1942">1942</option>
    <option value="1941">1941</option>
    <option value="1940">1940</option>
    <option value="1939">1939</option>
    <option value="1938">1938</option>
    <option value="1937">1937</option>
    <option value="1936">1936</option>
    <option value="1935">1935</option>
    <option value="1934">1934</option>
    <option value="1933">1933</option>
    <option value="1932">1932</option>
    <option value="1931">1931</option>
    <option value="1930">1930</option>
    <option value="1929">1929</option>
    <option value="1928">1928</option>
    <option value="1927">1927</option>
    <option value="1926">1926</option>
    <option value="1925">1925</option>
    <option value="1924">1924</option>
    <option value="1923">1923</option>
    <option value="1922">1922</option>
    <option value="1921">1921</option>
    <option value="1920">1920</option>
    <option value="1919">1919</option>
    <option value="1918">1918</option>
    <option value="1917">1917</option>
    <option value="1916">1916</option>
    <option value="1915">1915</option>
    <option value="1914">1914</option>
    <option value="1913">1913</option>
    <option value="1912">1912</option>
    <option value="1911">1911</option>
    <option value="1910">1910</option>
    <option value="1909">1909</option>
    <option value="1908">1908</option>
    <option value="1907">1907</option>
    <option value="1906">1906</option>
    <option value="1905">1905</option>
    <option value="1904">1904</option>
    <option value="1903">1903</option>
    <option value="1902">1902</option>
    <option value="1901">1901</option>
    <option value="1900">1900</option>

<?php
} // end of yearSelect
function monthSelect(){ ?>
    <option value="01">January</option>
    <option value="02">February</option>
    <option value="03">March</option>
    <option value="04">April</option>
    <option value="05">May</option>
    <option value="06">June</option>
    <option value="07">July</option>
    <option value="08">August</option>
    <option value="09">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
<?php
} // end of monthSelect

?>