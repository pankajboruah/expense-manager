<?php

include "init.php";

if (logged_in()) {
    header('Location: index.php');
    exit();
}

$errors = array();

if (isset($_POST['reg'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $phn = $_POST['phn'];
    $password = $_POST['password1'];
    $password2 = $_POST['password2'];


    if (empty($email) || empty($name) || empty($password) || empty($phn)) {
        array_push($errors, 'All fields are required');
    } else {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            array_push($errors, 'Email address not valid');
        }

        if (strlen($email) > 255 || strlen($name) > 255 || strlen($password) > 255 || strlen($phn) > 11) {
            array_push($errors, 'one or more fields consits too many characters');
        }
        if ($password!=$password2) {
            array_push($errors, "Confirm Password doesn't match.");
        }

        if (user_exists($email) === true) {
            array_push($errors, 'That email has already registered.');
        }
        
    }
    if(count($errors)==0) {
        user_register($email, $name, $phn, $password);
        $query="select * from users where email='$email' limit 1";
        $result=mysqli_query($db, $query);
        if(!$result) {
            die("error : ".$db->error);
        }
        $row=mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        header('Location: index.php');
        exit();
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
<body class="reg-body">
    
    <div class="container reg-container">
       <div class="row">
          <div class="my-reg-box">
              <h3 class="form-heading">REGISTER</h3>
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
              <form class="form-horizontal" method="post" action="register.php">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Name : </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="Name" name="name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Email : </label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Phone : </label>
                    <div class="col-sm-8">
                        <input type="tel" maxlength="10" pattern="[0-9]{10}" title="digits only and maximum 10 characters" class="form-control" placeholder="Phone" name="phn" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label" >Password : </label>
                    <div class="col-sm-8">
                        <input type="password" pattern="((?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$)" title="UpperCase, LowerCase, Number/SpecialChar and min 8 Chars." class="form-control" placeholder="Password" name="password1" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label" required>Confirm : </label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" placeholder="Confirm Password" name="password2" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-3">
                        <button type="submit" name="reg" class="btn btn-success">Register</button>
                    </div>
                    <div class="col-sm-6">
                        Already have an account?<a href="../arbre_expense/" style="color:#5cb85c"> Login</a>
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