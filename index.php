<?php

include "includes/setup.php";

include "init.php";

if (logged_in()) {
    header('Location: home.php');
    exit();
}

$errors=array();
if(isset($_POST['login']))
login_user();

if(isset($_POST['forgot_btn'])){
    if (!empty($_POST['hash_token'])) {
            if (hash_equals($_SESSION['token'], $_POST['hash_token'])) {
                // Proceed to process the form data
                header('location: forgot_pwd.php');
            } 
            else {
                die("token error");
                // Log this as a warning and keep an eye on these attempts
            }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ARBRE | Expense Manager</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,700,700i" rel="stylesheet">
</head>
<body class="login-body">
    
    <div class="container login-container">
       <div class="row">
          <div class="my-md-box">
              <h3 class="form-heading">LOGIN</h3>
              <?php
                    if(count($errors)!=0) { 
                ?>
                        <small class="col-sm-8 col-sm-offset-3" style="color:#faa;font-style:italic;font-size:1em;padding:5px;">
                            <?php foreach($errors as $e) {
                                    echo $e."<br/>";
                                  } 
                            ?>
                        </small>
                <?php
                    }
                ?>
              <form class="form-horizontal" method="post" action="index.php">
                <input type="hidden" name="hash_token" value="<?php echo $token;  ?>">

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                              <input type="checkbox" name="remember" value="1"> Remember me
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-3">
                        <button type="submit" class="btn btn-success" name="login">Sign in</button>
                    </div>
                    <div class="col-sm-6">
                        Don't have an account?<a href="register.php" style="color:#5cb85c"> Register</a>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-3">
                        <button type="submit" class="btn btn-success" name="forgot_btn">Forgot Password</button>
                    </div>    
                </div>
              </form>
          </div>
       </div>        
    </div>
    
<script src="js/jquery.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>

</body>
</html>