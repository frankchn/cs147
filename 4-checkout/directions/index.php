<?php
  //settings
  
    $T1O    = "1450 Jayhawk Blvd #223 Lawrence, KS 66045"; //company address
  
  //end settings
  
  //they seem to have JS disabled, let's redirect them to
  //Google Maps and prefill the query
  if($_POST['submit']) {
    $FROM  = $_POST['street'] . " " . $_POST['city'] . ", " . $_POST['state'] . " " . $_POST['zip'];
    $LOC   = $_POST['language'];
    
    $url   = "http://maps.google.com/maps?hl=".urlencode($LOC)."&q=from:".urlencode($FROM)."+to:".urlencode($TO)."&ie=UTF8";
    
    header("Location: " . $url);
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
       "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>
    <title>University of Kansas: How To Find Us</title>
    
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <script src="http://maps.google.com/?file=api&v=2&key=INSERT_API_KEY" type="text/javascript"></script>
    <script src="./js/application.js" type="text/javascript"></script>
  </head>
  
  <body onload="initialize()">
    <div id="pagewrap">
      
      <h1 class="title">How To Find Us!</h1>
      
      <div id="map_canvas"></div>
      
      
      
      
      <div id="addresses">
          <div class="address-panel">
              <h2>Our Address</h2>
              <address>
                1450 Jayhawk Blvd #223<br />
                Lawrence, KS<br />
                66045
              </address>
          </div>
          
          <div class="address-panel">
              <h2>Your Address</h2>
              
              <form action="./index.php" onsubmit="overlayDirections();return false;" method="post">
                  <div>
                    <label for="street">Street Address</label>
                    <input id="street" name="street_address" type="text" />
                  </div>
                  <div>
                    <div class="address-form-column">
                      <label for="city">City</label>
                      <input id="city" name="city" type="text" />
                    </div>
                    
                    <div class="address-form-column">
                      <label for="state">State</label>
                      <select id="state" name="state">
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
                      </select>
                    </div>
                    
                    <div class="address-form-column">
                      <label for="zip">Zip Code</label>
                      <input id="zip" name="zip_code" type="text" maxlength="5" size="5" />
                    </div>
                  </div>
                  
                  <div class="button">
                    <select id="language" name="language">
                      <option value="en" selected>English</option>
                      <option value="fr">French</option>                  
                      <option value="de">German</option>
                      <option value="ja">Japanese</option>
                      <option value="es">Spanish</option>
                    </select>
                    <input name="submit" type="submit" value="Get Directions" />
                  </div>
              </form>
          </div>
      </div>
      
      <div id="directions"></div>
      
    </div>
  </body>

</html>