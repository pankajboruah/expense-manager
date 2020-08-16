<?php
function logged_in() {
    if(isset($_COOKIE['uid'])) {
        $_SESSION['uid']=$_COOKIE['uid'];
    }
    return isset($_SESSION['uid']);
}

function login_check($email, $password) {
    global $db;
    $query="select * from users where email='$email' and password='$password'";
    $result=mysqli_query($db, $query);
    if(!$result) {
        die("error : ".$db->error);
    }
    if($result->num_rows == 1) {
        $row=mysqli_fetch_assoc($result);
        return $row['uid'];
    }
    else {
        return false;
    }
}

function login_user(){
    global $errors;
    if(isset($_POST['email'], $_POST['password'])) {
        global $db;
        $email=mysqli_real_escape_string($db, $_POST['email']);
        $pwd=md5(mysqli_real_escape_string($db, $_POST['password']));
//        $pwd=mysqli_real_escape_string($db, $_POST['password']);
        
        if(empty($email) || empty($pwd)) {
            array_push($errors, "All fields are necessary.");
        }
        else {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                array_push($errors, 'Email address not valid');
            }
            $uid=login_check($email, $pwd);
            if($uid==false) {
                array_push($errors, "Invalid details.");
            }
            else {
                $_SESSION['uid']=$uid;
                if(isset($_POST['remember']) && $_POST['remember']=="1") {
                    setcookie("uid", $uid, (time()+30*24*60*60));
                }
                header("location: home.php");
            }
        }
    }
}

function user_data() {
    global $db;
    $args = func_get_args();
    $fields = "`".implode("`, `", $args)."`";
    $query="select $fields from users where uid=".$_SESSION['uid'];
    $result=mysqli_query($db, $query);
    if(!$result) {
        die("error : ".$db->error);
    }
    $row=mysqli_fetch_assoc($result);
    $n=count($args);
    foreach($args as $a) {
        $args[$a]=$row[$a];
    }
    return $args;
}

function user_register($email, $name, $phn, $password) {
    global $db;
    $email = mysqli_real_escape_string($db, $email);
    $name = mysqli_real_escape_string($db, $name);
    $phn = mysqli_real_escape_string($db, (int)$phn);
    $query="INSERT INTO `users`(email, name, password, phn) VALUES ('$email','$name','" . md5($password) . "', $phn)";
    if(!mysqli_query($db, $query)) {
        die("Error registering user : ".$db->error);
    }
    else {
        $uid=mysqli_insert_id($db);
        $cat=array();
        array_push($cat, array('title'=>"Bills",'name'=>"fas fa-file-invoice-dollar",'color'=>" #03c16c",'type'=>"E"));
        array_push($cat, array('title'=>"Car",'name'=>"fas fa-car",'color'=>"#c61166",'type'=>"E"));
        array_push($cat, array('title'=>"Clothes",'name'=>"fas fa-tshirt",'color'=>"#f22015",'type'=>"E"));
        array_push($cat, array('title'=>"Communication",'name'=>"fas fa-phone-volume",'color'=>"#8c6e6d",'type'=>"E"));
        array_push($cat, array('title'=>"Device",'name'=>"fas fa-mobile-alt",'color'=>"#0dddd6",'type'=>"E"));
        array_push($cat, array('title'=>"Eating out",'name'=>"fas fa-concierge-bell",'color'=>"#2f4666",'type'=>"E"));
        array_push($cat, array('title'=>"Food",'name'=>"fas fa-utensils",'color'=>"#8ad666",'type'=>"E"));
        array_push($cat, array('title'=>"Snacks",'name'=>"fas fa-cookie-bite",'color'=>"#c9cbf2",'type'=>"E"));
        array_push($cat, array('title'=>"Entertainment",'name'=>"fas fa-cocktail",'color'=>"#ffcf3f",'type'=>"E"));
        array_push($cat, array('title'=>"Gifts",'name'=>"fas fa-gift",'color'=>"#f7afb8",'type'=>"E"));
        array_push($cat, array('title'=>"Health",'name'=>"fas fa-hand-holding-heart",'color'=>"#e83e53",'type'=>"E"));
        array_push($cat, array('title'=>"House",'name'=>"fas fa-home",'color'=>"#f1c40f",'type'=>"E"));
        array_push($cat, array('title'=>"Pets",'name'=>"fas fa-paw",'color'=>"#5b8e74",'type'=>"E"));
        array_push($cat, array('title'=>"Sports",'name'=>"fas fa-swimmer",'color'=>"#44e2ab",'type'=>"E"));
        array_push($cat, array('title'=>"School",'name'=>"fas fa-school",'color'=>"#1927e8",'type'=>"E"));
        array_push($cat, array('title'=>"Taxi",'name'=>"fas fa-taxi",'color'=>"#cccc06",'type'=>"E"));
        array_push($cat, array('title'=>"Toiletry",'name'=>"fas fa-bath",'color'=>"#7984ce",'type'=>"E"));
        array_push($cat, array('title'=>"Transport",'name'=>"fas fa-bus-alt",'color'=>"#ad53d1",'type'=>"E"));
        array_push($cat, array('title'=>"Deposits",'name'=>"fas fa-donate",'color'=>"#3e8ad6",'type'=>"I"));
        array_push($cat, array('title'=>"Salary",'name'=>"fas fa-money-bill-wave",'color'=>"#62c13a",'type'=>"I"));
        array_push($cat, array('title'=>"Savings",'name'=>"fas fa-piggy-bank",'color'=>"#ef3502",'type'=>"I"));
        foreach($cat as $c) {
            $icon=$c['name'];
            $color=$c['color'];
            $title=$c['title'];
            $type=$c['type'];
            $query="insert into category(uid, icon, color, title, type) values($uid, '$icon', '$color', '$title', '$type')";
            if(!mysqli_query($db, $query)) {
                die("insert category failed: ".$db->error);
            }
        }
    }
}

function user_exists($email) {
    global $db;
    $email = mysqli_real_escape_string($db, $email);
    $result = mysqli_query($db, "SELECT count(uid) FROM `users` WHERE `email`='$email'");
    if(!$result) {
        die("error : ".$db->error);
    }
    $row=mysqli_fetch_assoc($result);
    return ($row['count(uid)'] == 1) ? true : false;
}

function transfer($amount,$description,$from,$to,$timestamp){
    global $db;
    global $errors;
    $user=user_data('uid','name','email','total_balance','cash','bank','other');
    if($from == $to){
        array_push($errors,"cannot transfer to same account");
?>
        <script>
            alert("cannot transfer to same account");
        </script>
<?php
    }
    else{
        if($amount<=$user[$from]){
            $query="update users set $from=($user[$from]-$amount) where uid=".$user['uid'];
            if(!mysqli_query($db,$query)){
                die("failed updation of $from table".$db->error);
            }
            $query="update users set $to=($user[$to]+$amount) where uid=".$user['uid'];
            if(!mysqli_query($db,$query)){
                die("failed updation of $to table".$db->error);
            }
            $query="insert into transfer (uid,amount,description,`from`,`to`,timestamp) values (".$user['uid'].",$amount,'$description','$from','$to',$timestamp)";
            if(!mysqli_query($db,$query)){
                die("failed insertion into transfer table".$db->error);
            }

        }
        else{
            array_push($errors, "Insufficient amount.");
?>
            <script>
                alert("Insufficient amount.");
            </script>
<?php
        }
    }
}

function showMonth($table) {
    global $db;
    $months=array("Jan","Feb","Mar","Apr","May","June","July","Aug","Sept","Oct","Nov","Dec");
    $query="SELECT year FROM $table where uid = ".$_SESSION['uid']." group by year order by year asc";
    $result =mysqli_query($db,$query);
    if(!$result){
        die("Query FAILED".$db->error);
    }
    if($result->num_rows > 0)
    while($row = mysqli_fetch_assoc($result)){
        $year=$row['year'];
        $q="select month from $table where uid = ".$_SESSION['uid']." and year=$year group by month order by month asc";
        $result=mysqli_query($db, $q);
        if(!$result){
            die("Query FAILED".$db->error);
        }
        if($result->num_rows > 0)
        while($r = mysqli_fetch_assoc($result)){
            $val=$r['month'];
            echo "<option value='$val-$year'>".$months[$val-1]." $year</option>";
        }
    }
}

function showYear($table){
    global $db;
    $query="SELECT * FROM $table where uid = ".$_SESSION['uid']." group by year order by year desc";
    $result =mysqli_query($db,$query);
    if(!$result){
        die("Query FAILED".$db->error);
    }
    if($result->num_rows > 0)
    while($row = mysqli_fetch_assoc($result)){
        $id=$row['year'];
        echo "<option value='$id'>$id</option>";
    }    
    
}

function reset_pwd($email, $new_pwd){
    global $db;
    $query = "UPDATE users set password = '".md5($new_pwd)."' where email = '$email'";
    $result = mysqli_query($db, $query);
    if(!$result){
        die("error :".$db->error);
    }
}
?>