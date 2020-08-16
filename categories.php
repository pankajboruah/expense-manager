<?php
include "init.php";
date_default_timezone_set("Asia/kolkata");
$uid=$_SESSION['uid'];

if(!logged_in()){
    header("location: index.php");
    exit();
}

$now=time();
$date=date("d", $now);
$month=date("m", $now);
$year=date("Y", $now);

$errors = array();

if(isset($_POST['transfer'])){
    $now=time();
    $amount=$_POST['amount'];
    $description=$_POST['desc'];
    $from=$_POST['from'];
    $to=$_POST['to'];
    transfer($amount,$description,$from,$to,$now);
//    header("location: home.php");
}

$user=user_data('uid','name','email','total_balance','cash','bank','other');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ARBRE | Categories</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/radio.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>
<body>
   
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand"><span class="fas fa-feather-alt"></span> Arbre</a>
            </div>
            
            <div class="collapse navbar-collapse" id="nav-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="home.php"><i class="fas fa-rupee-sign"></i> Expense</a></li>
                    <li><a href="income.php"><i class="fas fa-hand-holding-usd"></i> Income</a></li>
                    <li><a href="budget.php"><i class="fas fa-clipboard-check"></i> Budget Planner</a></li>
                    <li><a href="billsplit.php"><i class="fas fa-columns"></i> Bill Spliter</a></li>
                    <li><a href="logout.php"><i class="fas fa-power-off"></i> Logout</a></li>
                    <li class="settings hidden-xs" onclick="togglesidebar()"><a href="#"><i class="fas fa-cogs"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="sidebar">
        <ul>
            <a href="categories.php" style="text-decoration:none;"><li>Categories</li></a>
            <div class="dropdown">
            
            <li onclick="menubtn('arrow-down','arrow-up')" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Accounts <i id="arrow-down" class="fas fa-arrow-circle-down" style="display:inline"></i><i id="arrow-up" class="fas fa-arrow-circle-up" style="display:none"></i></li>
            
            <div id="accounts-drop" class="dropdown-menu" aria-labelledby="dropdownMenu1">
            
            <p style="color:#2c3e50;font-weight:600">
            <i class="fas fa-money-bill-wave" style="color:#62c13a;font-size:1.2em"></i> Cash: <?php echo $user['cash'] ?>
            <br>
            <i class="fas fa-university" style="color:#3e8ad6;font-size:1.2em"></i> Bank: <?php echo $user['bank'] ?>
            <br>
            <i class="fas fa-wallet" style="color:#ef3502;font-size:1.2em"></i> Other wallet: <?php echo $user['other'] ?>
            <br>
            <br>
            TRANSFER
            <p/>            
            <form action="" method="post" style="width:90%;">
                <input name="amount" type="tel" pattern="[0-9]+" title="Numeric values only." placeholder="$ Amount" class="form-control" style="font-size:1.5em;">
                <input name="desc" placeholder="Description (optional)" class="form-control" style="margin-top:5px;border-top:none;border-left:none;border-right:none;background:transparent;font-size:0.7em;">
                <label style="color:#2c3e50;">From:</label>
                <select name="from" class="form-control" required>
                    <option value="" disabled selected>Select Account</option>
                    <option value="cash">Cash</option>
                    <option value="bank">Bank Account</option>
                    <option value="other">Other Wallet</option>
                </select>
                <label style="color:#2c3e50;width:100%;">To:<i class="fas fa-angle-double-down" style="color:#62c13a;font-size:1.2em;margin-left:35%;"></i></label>
                <select name="to" class="form-control" required>
                    <option value="" disabled selected>Select Account</option>
                    <option value="cash">Cash</option>
                    <option value="bank">Bank Account</option>
                    <option value="other">Other Wallet</option>
                </select>
                <button type="submit" name="transfer" class="btn btn-success" style="margin-top:5px"><i class="fas fa-exchange-alt"></i> Transfer</button>
            </form>
            
            </div>
            </div>
            <li>Currency</li>
            <li>Settings</li>
        </ul>
    </div>
    <div class="visible-xs-block mobile-tooltray">
        <a href="#" style="display:none;"></a>
        <a href="#" id="toggle2" onclick="togglesidebar2()"><i class="fas fa-cogs"></i></a>
    </div>
    
    <div class="container" id="content1">
        <h2>Your Categories</h2>
        <?php include "includes/temp.comingSoon.php"; ?>
    </div>
    
    
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="js/script.js"></script>


</body>
</html>