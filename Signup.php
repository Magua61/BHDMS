<!DOCTYPE html>
<?php include 'db_connection.php'; 
include 'signup_model.php'?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <!-- FONT -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
  <!-- PLUGINS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css" integrity="sha512-Ars0BmSwpsUJnWMw+KoUKGKunT7+T8NGK0ORRKj+HT8naZzLSIQoOSIIM3oyaJljgLxFi0xImI5oZkAWEFARSA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <div id="loading" style="display: none;">
      <div class="spinner-grow text-primary" style="width: 10rem; height: 10rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>          
  </div>
  <div>
  <!-- FORMS -->
  <div class="form_holder">
    <form action="signup_controller.php" method="POST" id="msform">
      <ul id="progressbar">
        <li class="active">1. Personal Information</li>
        <li>2. Family History</li>
        <li>3. Health Details</li>
      </ul>
      <fieldset>
        <h2 class="fs-title">Personal Information</h2>
        <h3 class="fs-subtitle">Please Input your Personal Information to Sign Up.</h3>
        <input type="text" class="form-input" id="fname" name="user_name" placeholder="Full name" required/>
        <input type="date" class="form-input" id="birthday" name="user_birthday" style="width: 43%" required/>
        <input type="number" class="form-input" id="age" name="user_age" placeholder="Age" style="width: 23%" required/>
        <select name="user_gender" id="gender" style="width: 33%" required>
            <option value="">Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <input type="text" class="form-input" id="email" name="user_email" placeholder="Email address" style="width: 49%" required>
        <input type="text" class="form-input" id="phone" name="user_phone" placeholder="Contact number" style="width: 50%" required>
        <input type="text" class="form-input" id="ethnicity" name="user_ethnicity" placeholder="Ethnicity" style="width: 49%" required>
        <input type="text" class="form-input" id="occupation" name="user_occupation" placeholder="Occupation" style="width: 50%" required>
        <textarea class="form-input" id="address" name="user_address" placeholder="Address" required></textarea>
        <input type="password" class="form-input" id="password" name="user_password" placeholder="Password" style="width: 49%" required>
        <input type="password" class="form-input" id="confirm" name="user_confirm" placeholder="Confirm password" style="width: 50%" required>
        <a href="index.php" class="button"> Cancel </a>
        <input type="button" name="next" class="next action-button" value="Next" />
      </fieldset>

      <fieldset>
        <h2 class="fs-title">Family History</h2>
        <!-- <h3 class="fs-subtitle">Your Family History</h3> -->
        <div class="select-container">
          <div class="select-wrapper">
            <select name="family_id" id="ftree" required>
                <option value="">Choose Family...</option>
                <?php
                  foreach($familydata as $f):{
                    echo '<option value="'.$f['family_id'].'">'.$f['family_name'].'</option>';
                  }
                  endforeach;
                ?>
            </select>
          </div>

          <div class="select-wrapper">
            <select name="family_position" id="role">
                <option value="">Choose Role..</option>
                <option value="Father">Father</option>
                <option value="Mother">Mother</option>
                <option value="Grandfather">Grandfather</option>
                <option value="Grandmother">Grandmother</option>
                <option value="Child">Child</option>
            </select>
          </div>
      </div>
        <h2 class="fs-title">Medical History</h2>
        <h3 class="fs-subtitle">Have you ever had any of these conditions? Please select the items that you had or currently have.</h3>
        <select name="disease_name" id="mhistory" multiple="multiple" style="width: 100%">
          <?php
              foreach($diseasedata as $d):{
                echo '<option value="'.$d['disease_id'].'">'.$d['disease_name'].'</option>';
              }
              endforeach;
          ?>
        </select><br>

        <h2 class="fs-title">Vaccination</h2>
        <select name="vaccine_name" id="vaccine" style="width: 49%">
          <option value=""> Vaccine Type </option>
          <?php
              foreach($vaccinedata as $v):{
                echo '<option value="'.$v['vaccine_id'].'">'.$v['vaccine_name'].'</option>';
              }
              endforeach;
            ?>
        </select>
        <input type="date" id="vacdate" name="vacdate" style="width: 50%">
        <input type="button" name="previous" class="previous action-button" value="Previous" />
        <input type="button" name="next" class="next action-button" value="Next" />
      </fieldset>

      <fieldset>
        <h2 class="fs-title">Health Details</h2>
        <h3 class="fs-subtitle">Current and Previous Health Conditions</h3>
        <select name="disease_name" id="current" multiple="multiple" style="width: 100%">
          <?php
              foreach($currentdata as $c):{
                echo '<option value="'.$c['disease_id'].'">'.$c['disease_name'].'</option>';
              }
              endforeach;
          ?>
        </select><br>
        <select name="allergy_name" id="allergies" multiple="multiple" style="width: 100%">
          <?php
              foreach($allergydata as $a):{
                echo '<option value="'.$a['allergy_id'].'">'.$a['allergy_name'].'</option>';
              }
              endforeach;
          ?>
      </select><br>
      <select name="medicine_name" id="medications" multiple="multiple" style="width: 100%">
        <?php
              foreach($medicinedata as $m):{
                echo '<option value="'.$m['medicine_id'].'">'.$m['medicine_name'].'</option>';
              }
              endforeach;
          ?>
    </select><br>
    <select name="mental_name" id="mental" multiple="multiple" style="width: 100%">
      <?php
          foreach($mentaldata as $mn):{
            echo '<option value="'.$mn['mental_id'].'">'.$mn['mental_name'].'</option>';
          }
          endforeach;
        ?>
  </select><br>

    <h2 class="fs-title">Habits</h2>
    <h3 class="fs-subtitle">Please answer the following questions honestly, check Yes or No.</h3>
    <div class="checkbox-container">
      <h5> Do you smoke?</h5>
        <div>
            <input type="radio" id="smoking1" name="smoking" value="1">
            <label for="smoking1"> Yes</label>
        </div>
        <div>
            <input type="radio" id="smoking2" name="smoking" value="0">
            <label for="smoking2"> No</label>
        </div>

      <h5 style="margin-left: 30px;"> Do you drink alcohol?</h5>
        <div>
            <input type="radio" id="drinking1" name="drinking" value="1">
            <label for="drinking1"> Yes</label>
        </div>
        <div>
            <input type="radio" id="drinking2" name="drinking" value="0">
            <label for="drinking2"> No</label>
        </div>
        
      <h5 class="question" style="margin-left: 30px;"> Do you use other substances?</h5>
        <div>
            <input type="radio" id="drugs1" name="drugs" value="1">
            <label for="drugs1"> Yes</label>
        </div>
        <div>
            <input type="radio" id="drugs2" name="drugs" value="0">
            <label for="drugs2"> No</label>
        </div>
    </div>
        <input type="button" name="previous" class="previous action-button" value="Previous" />
        <input type="submit" name="submit" class="submit action-button" value="Submit" />
      </fieldset>
    </form>
    </div>
    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://www.jqueryscript.net/demo/Creating-A-Modern-Multi-Step-Form-with-jQuery-CSS3/js/jquery.easing.min.js"></script>
    <script>

    $(document).ready(function() {

        $("#ftree").selectize({
          create: true
        });
        $("#role").selectize({
          create: true
        });

        $('#mhistory').selectize({
            create: true,
            maxItems: null,
            plugins: ['remove_button'],
            placeholder: 'Select conditions.....'
        });

        $('#current').selectize({
            create: true,
            maxItems: null,
            plugins: ['remove_button'],
            placeholder: 'Select conditions.....'
        });

        $('#medications').selectize({
            create: true,
            maxItems: null,
            plugins: ['remove_button'],
            placeholder: 'Select medications'
        });

        $('#allergies').selectize({
            create: true,
            maxItems: null,
            plugins: ['remove_button'],
            placeholder: 'Select allergies'
        });

        $('#mental').selectize({
            create: true,
            maxItems: null,
            plugins: ['remove_button'],
            placeholder: 'Select mental state'
        });
    });

        // document.getElementById('ftree').addEventListener('change', function() {
        //     var secondDropdown = document.getElementById('role');
        //     if (this.value !== "") {
        //         role.style.display = 'block';  // Show the second dropdown
        //     } else {
        //         role.style.display = 'none';   // Hide the second dropdown
        //     }
        // });
     </script>
</body>
</html>

