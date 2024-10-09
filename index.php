<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!----------------------- Main Container -------------------------->

     <div class="container d-flex justify-content-center align-items-center col-md-6 min-vh-100">

    <!----------------------- Login Container -------------------------->

       <div class="row border rounded-5 p-3 bg-white shadow box-area">
        <form action="login_controller.php" method="POST">
    <!--------------------------- Left Box ----------------------------->

       <!-- <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #27AE60;">
           <div class="featured-image mb-3">
            <img src="images/1.png" class="img-fluid" style="width: 250px;">
           </div>
           <p class="text-white fs-2" style="font-weight: 600;">Be Verified</p>
           <small class="text-white text-wrap text-center" style="width: 17rem;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small>
       </div>  -->

    <!-------------------- ------ Right Box ---------------------------->
        
       <div class="col-md-4 mx-auto center-box">
          <div class="row align-items-center">
                <div class="header-text mb-4 text-center">
                     <h2>Hello,Again</h2>
                     <p>We are happy to have you back.</p>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="user_email" class="form-control form-control-lg bg-light fs-6" placeholder="Email address">
                </div>
                <div class="input-group mb-1">
                    <input type="password" name="user_password" class="form-control form-control-lg bg-light fs-6" placeholder="Password">
                </div>
                <div class="input-group mb-5 d-flex justify-content-between">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="formCheck">
                        <label for="formCheck" class="form-check-label text-secondary"><small>Remember Me</small></label>
                    </div>
                    <div class="forgot">
                        <small><a href="#">Forgot Password?</a></small>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <button name="login" class="btn btn-lg btn-primary w-100 fs-6" style="background-color: #27AE60 !important;">Login</button>
                </div>
                <div class="row text-center">
                    <small>Don't have account? <a href="Signup.php">Sign Up</a></small>
                </div>
          </div>
       </div> 
    </form>
      </div>
    </div>
</body>
</html>