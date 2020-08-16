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
$months=array("January","February","March","April","May","June","July","August","September","October","November","December");
$subHeading=$months[$month-1]." ".$year;

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
$cat=get_categories();

if(isset($_POST['addEx'])) {
    $uid=$_SESSION['uid'];
    $now=time();
    $d=date("d", $now);
    $m=date("m", $now);
    $y=date("Y", $now);
    insert_expense($uid,$_POST['amount'],$_POST['category'],$_POST['desc'],$_POST['account'],$now,$d,$m,$y);
    header("location: home.php");
}
//if(isset($_POST['addInc'])) {
//    die("hmm");
//    $uid=$_SESSION['uid'];
//    $now=time();
//    $d=date("d", $now);
//    $m=date("m", $now);
//    $y=date("Y", $now);
//    insert_income($uid,$_POST['amount'],$_POST['category'],$_POST['account'],$now,$d,$m,$y);
//    header("location: income.php");
//}

$sum=0;
$expense=monthStatsExpense($month, $year);

if(isset($_POST['yesterday']) and $_POST['yesterday']==1) {
    $timestamp=$now-(60*60*24);
    $date=date("d", $timestamp);
    $month=date("m", $timestamp);
    $year=date("Y", $timestamp);
    $expense=dateStatsExpense($date,$month,$year);
    $subHeading=$date." ".$months[$month-1]." ".$year;
}

if(isset($_POST['today']) and $_POST['today']==1) {
    $expense=dateStatsExpense($date,$month,$year);
    $subHeading=$date." ".$months[$month-1]." ".$year;
}

if(isset($_POST['this_month']) and $_POST['this_month']==1) {
    $expense=monthStatsExpense($month,$year);
    $subHeading=$months[$month-1]." ".$year;
}

if(isset($_POST['this_year']) and $_POST['this_year']==1) {
    $expense=yearStatsExpense($year);
    $subHeading=$year;
}

if(isset($_POST['showForDate'])){
    $date=$_POST['date'];
    $exploded=explode("-",$date);
    $date=$exploded['2'];
    $month=$exploded['1'];
    $year=$exploded['0'];
    $expense=dateStatsExpense($date,$month,$year);
    $subHeading=$date." ".$months[$month-1]." ".$year;
}

if(isset($_POST['showForDuration'])){
    $date1=$_POST['from'];
    $exploded=explode("-",$date1);
    $date1=$exploded['2'];
    $month1=$exploded['1'];
    $year1=$exploded['0'];
    $newTime1=mktime(0,0,0,$month1,$date1,$year1);
    $date2=$_POST['to'];
    $exploded=explode("-",$date2);
    $date2=$exploded['2'];
    $month2=$exploded['1'];
    $year2=$exploded['0'];
    $newTime2=mktime(24,0,0,$month2,$date2,$year2);
//    die("@".$newTime1."@".$newTime2);
    $expense=durationStatsExpense($newTime1,$newTime2);
    $subHeading=$date1." ".$months[$month1-1]." ".$year1." - ".$date2." ".$months[$month2-1]." ".$year2;;
}

if(isset($_POST['showForMonth'])){
    $month=$_POST['month'];
    $exploded=explode("-",$month);
    $month=$exploded['0'];
    $year=$exploded['1'];
    $expense=monthStatsExpense($month, $year);
    $subHeading=$months[$month-1]." ".$year;
}

if(isset($_POST['showForYear'])){
    $year=$_POST['year'];
    $expense=yearStatsExpense($year);
    $subHeading=$year;
}

foreach($expense as $e) {
    $sum=$sum+$e['amount'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ARBRE | Home</title>
    <link rel="stylesheet" href="css/chart.css">
    <link rel="stylesheet" href="css/theme.css">
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
                    <li class="active"><a href="home.php"><i class="fas fa-rupee-sign"></i> Expense</a></li>
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
        <div  class="hidden-xs">
            <hr>
            <ul class="extra-lg-option">
                <li onclick="document.getElementById('form1').submit();">
                    Yesterday
                    <form id="form1" action="" method="post"><input type="hidden" name="yesterday" value=1></form>
                </li>
                <li onclick="document.getElementById('form2').submit();">
                    Today
                    <form id="form2" action="" method="post"><input type="hidden" name="today" value=1></form>
                </li>
                <li onclick="document.getElementById('form3').submit();">
                    This Month
                    <form id="form3" action="" method="post"><input type="hidden" name="this_month" value=1></form>
                </li>
                <li onclick="document.getElementById('form4').submit();">
                    This Year
                    <form id="form4" action="" method="post"><input type="hidden" name="this_year" value=1></form>
                </li>
                <div class="dropdown">
                    <li onclick="menubtn('icon1','icon2')" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Duration <i id="icon1" class="fas fa-arrow-circle-down" style="display:inline"></i><i id="icon2" class="fas fa-arrow-circle-up" style="display:none"></i></li>

                    <div id="accounts-drop" class="dropdown-menu" aria-labelledby="dropdownMenu2">            
                    <form action="" method="post" style="width:90%;">
                        <input type="date" name="from" class="form-control" style="font-size:0.8em">
                        <input type="date" name="to" class="form-control" style="font-size:0.8em">
                        <button type="submit" name="showForDuration" class="btn btn-success" style="margin-top:5px">Show</button>
                    </form>
                    </div>
                </div>
                <div class="dropdown">
                    <li onclick="menubtn('icon3','icon4')" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Choose Date <i id="icon3" class="fas fa-arrow-circle-down" style="display:inline"></i><i id="icon4" class="fas fa-arrow-circle-up" style="display:none"></i></li>

                    <div id="accounts-drop" class="dropdown-menu" aria-labelledby="dropdownMenu3">            
                    <form action="" method="post" style="width:90%;">
                        <input type="date" name="date" class="form-control" style="font-size:0.8em">
                        <button type="submit" name="showForDate" class="btn btn-success" style="margin-top:5px">Show</button>
                    </form>
                    </div>
                </div>
                <div class="dropdown">
                    <li onclick="menubtn('icon5','icon6')" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Choose Month <i id="icon5" class="fas fa-arrow-circle-down" style="display:inline"></i><i id="icon6" class="fas fa-arrow-circle-up" style="display:none"></i></li>

                    <div id="accounts-drop" class="dropdown-menu" aria-labelledby="dropdownMenu3">            
                    <form action="" method="post" style="width:90%;">
                        <select name="month" style="font-size:0.8em" class="form-control">
                            <option value="" disabled selected>Select Month</option>
                            <?php showMonth('expense');?>
                        </select>
                        <button type="submit" name="showForMonth" class="btn btn-success" style="margin-top:5px">Show</button>
                    </form>
                    </div>
                </div>
                <div class="dropdown" style="margin-bottom:100px;">
                    <li onclick="menubtn('icon7','icon8')" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Choose Year <i id="icon7" class="fas fa-arrow-circle-down" style="display:inline"></i><i id="icon8" class="fas fa-arrow-circle-up" style="display:none"></i></li>

                    <div id="accounts-drop" class="dropdown-menu" aria-labelledby="dropdownMenu3">            
                    <form action="" method="post" style="width:90%;">
                        <select name="year" style="font-size:0.8em" class="form-control">
                            <option value="" disabled selected>Select Year</option>
                            <?php showYear('expense');?>
                        </select>
                        <button type="submit" name="showForYear" class="btn btn-success" style="margin-top:5px">Show</button>
                    </form>
                    </div>
                </div>
            </ul>            
        </div>
    </div>
    <div id="left-sidebar" class="visible-xs-block">
        <ul>
            <li onclick="document.getElementById('form5').submit();">
                Yesterday
                <form id="form5" action="" method="post"><input type="hidden" name="yesterday" value=1></form>
            </li>
            <li onclick="document.getElementById('form6').submit();">
                Today
                <form id="form6" action="" method="post"><input type="hidden" name="today" value=1></form>
            </li>
            <li onclick="document.getElementById('form7').submit();">
                This Month
                <form id="form7" action="" method="post"><input type="hidden" name="this_month" value=1></form>
            </li>
            <li onclick="document.getElementById('form8').submit();">
                This Year
                <form id="form8" action="" method="post"><input type="hidden" name="this_year" value=1></form>
            </li>
            <div class="dropdown">
                <li onclick="menubtn('icon1','icon2')" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Duration <i id="icon1" class="fas fa-arrow-circle-down" style="display:inline"></i><i id="icon2" class="fas fa-arrow-circle-up" style="display:none"></i></li>

                <div id="accounts-drop" class="dropdown-menu" aria-labelledby="dropdownMenu2">            
                <form action="" method="post" style="width:90%;">
                    <input type="date" name="from" class="form-control" style="font-size:0.8em">
                    <input type="date" name="to" class="form-control" style="font-size:0.8em">
                    <button type="submit" name="showForDuration" class="btn btn-success" style="margin-top:5px">Show</button>
                </form>
                </div>
            </div>
            <div class="dropdown">
                <li onclick="menubtn('icon3','icon4')" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Choose Date <i id="icon3" class="fas fa-arrow-circle-down" style="display:inline"></i><i id="icon4" class="fas fa-arrow-circle-up" style="display:none"></i></li>

                <div id="accounts-drop" class="dropdown-menu" aria-labelledby="dropdownMenu3">            
                <form action="" method="post" style="width:90%;">
                    <input type="date" name="date" class="form-control" style="font-size:0.8em">
                    <button type="submit" name="showForDate" class="btn btn-success" style="margin-top:5px">Show</button>
                </form>
                </div>
            </div>
            <div class="dropdown">
                <li onclick="menubtn('icon5','icon6')" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Choose Month <i id="icon5" class="fas fa-arrow-circle-down" style="display:inline"></i><i id="icon6" class="fas fa-arrow-circle-up" style="display:none"></i></li>

                <div id="accounts-drop" class="dropdown-menu" aria-labelledby="dropdownMenu3">            
                <form action="" method="post" style="width:90%;">
                    <select name="month" style="font-size:0.8em" class="form-control">
                        <option value="" disabled selected>Select Month</option>
                        <?php showMonth('expense');?>
                    </select>
                    <button type="submit" name="showForMonth" class="btn btn-success" style="margin-top:5px">Show</button>
                </form>
                </div>
            </div>
            <div class="dropdown" style="margin-bottom:100px;">
                <li onclick="menubtn('icon7','icon8')" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Choose Year <i id="icon7" class="fas fa-arrow-circle-down" style="display:inline"></i><i id="icon8" class="fas fa-arrow-circle-up" style="display:none"></i></li>

                <div id="accounts-drop" class="dropdown-menu" aria-labelledby="dropdownMenu3">            
                <form action="" method="post" style="width:90%;">
                    <select name="year" style="font-size:0.8em" class="form-control">
                        <option value="" disabled selected>Select Year</option>
                        <?php showYear('expense');?>
                    </select>
                    <button type="submit" name="showForYear" class="btn btn-success" style="margin-top:5px">Show</button>
                </form>
                </div>
            </div>
        </ul>
    </div>
    <div class="visible-xs-block mobile-tooltray">
        <a href="#" id="toggle1" onclick="togglesidebar1()"><i id="right-arrow" class="fas fa-arrow-circle-right"></i><i id="left-arrow" class="fas fa-arrow-circle-left" style="display:none;"></i></a>
        <a href="#" id="toggle2" onclick="togglesidebar2()"><i class="fas fa-cogs"></i></a>
    </div>
    
    <div class="container" id="content1">
        <h2>My Expense</h2>
        <h4 style="color:#d84d4d;text-align:center;font-weight:600;"><?php echo $subHeading; ?></h4>
        <div class="row box">
            <div class="col-lg-6 col-xs-12" style="">
                <div style="width:100%;">
                    <canvas id="myDoughnut"></canvas>
                </div>                
            </div>
            <div class="col-lg-6 col-xs-12 legend">
                <div class="row">
                   <?php
                    foreach($expense as $e) {
                        $c=category_data($e['category'], "icon", "title", "color", "type");
                    ?>
                        <div class="col-md-3 col-sm-3 col-xs-4 category" data-toggle="modal" data-target="#category<?php echo $e['category']; ?>">
                            <i class="<?php echo $c['icon']; ?>" style="color:<?php echo $c['color']; ?>"></i> 
                            <span><?php echo $c['title']; ?></span>
                        </div>
                        <!-- Modal -->
                         <div class="modal fade" id="category<?php echo $e['category']; ?>" role="dialog">
                            <div class="modal-dialog">

                              <!-- Modal content-->
                              <div class="modal-content" style="margin-top:2%;">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h3 class="modal-title">
                                      <i class="<?php echo $c['icon']; ?>" style="color:<?php echo $c['color']; ?>"></i>
                                      <span><?php echo $c['title']; ?></span>
                                  </h3>
                                </div>
                                <div class="modal-body">
                                    <table style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th class="col1">Date and Time</th>
                                                <th class="col2">Description</th>
                                                <th class="col3">Account</th>
                                                <th class="col4">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ex_data=ex_category_data($e['category']);
                                            foreach($ex_data as $data) {
                                                $data_date=date("d M Y ", $data['timestamp']);
                                                $data_time=date(" h:i a", $data['timestamp']);
                                            ?>
                                                <tr>
                                                    <td class="col1"><span class="datetime"><?php echo $data_date; ?></span> - <span class="datetime"><?php echo $data_time; ?></span></td>
                                                    <td class="col2"><?php echo $data['description']; ?></td>
                                                    <td class="col3"><?php echo $data['account']; ?></td>
                                                    <td class="col4"><?php echo "<i class='fas fa-rupee-sign'></i>".$data['amount']; ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>

                            </div>
                          </div>
                        <!-- Modal -->
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-4 col-xs-12 btns">
                <center>
                    <button class="my-main-btns"  data-toggle="modal" data-target="#addExpense"><i class="fas fa-plus-circle">&nbsp; Expense</i></button>
                    <button class="my-main-btns" data-toggle="modal" data-target="#addIncome"><i class="fas fa-plus-circle">&nbsp; Income</i></button>
                    <!-- Modal -->
                     <div class="modal fade" id="addExpense" role="dialog">
                        <div class="modal-dialog">

                          <!-- Modal content-->
                          <div class="modal-content" style="margin-top:2%;">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h3 class="modal-title">Add Today's Expense</h3>
                            </div>
                            <form method="post" action="home.php">
                                <div class="modal-body">
                                <div class="row my-form-group">
                                    <div class=" col-xs-11 categories-label" onclick="toggleCollapse('categories-body-1')">Select category: <i class="fas fa-th"></i></div>

                                    <div id="categories-body-1" class="categories col-xs-12">
                                       <?php
                                        foreach($cat as $c) {
                                            if($c['type']=='E') {
                                        ?>
                                            <div class="col-xs-4 col-sm-3">
                                                <label class="radio-container"><i class="<?php echo $c['name']; ?>" style="color:<?php echo $c['color']; ?>"></i>
                                                  <center><p><?php echo $c['title']; ?></p></center>
                                                  <input type="radio" value="<?php echo $c['id']; ?>" name="category" required>
                                                  <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="col-xs-10 col-xs-offset-1">
                                        <input type="text" class="form-control" placeholder="Description  (optional)" name="desc" style="border-top:none;border-left:none;border-right:none;background:transparent;font-size:0.8em;">
                                    </div>
                                    <br>
                                    <br>
                                    <div class="col-xs-5 col-xs-offset-1" style="margin-top:5px;">
                                        <select name="account" class="form-control" required>
                                            <option value="" disabled selected>Select Account</option>
                                            <option value="cash">Cash</option>
                                            <option value="bank">Bank Account</option>
                                            <option value="other">Other Wallet</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-10 col-xs-offset-1" style="margin-top:5px;margin-bottom:10px;">
                                        <input id="field" type="tel"  pattern="[0-9]+" title="Numeric values only." class="form-control" placeholder="$ Amount" name="amount" required>
                                    </div>
                                    <div class="col-xs-10 col-xs-offset-1 numpad">
                                        <button type="button" value="1" class="col-xs-3 num-keys" onclick="append(this.value)">1</button>
                                        <button type="button" value="2" class="col-xs-3 num-keys" onclick="append(this.value)">2</button>
                                        <button type="button" value="3" class="col-xs-3 num-keys" onclick="append(this.value)">3</button>
                                        <button type="button" value="4" class="col-xs-3 num-keys" onclick="append(this.value)">4</button>
                                        <button type="button" value="5" class="col-xs-3 num-keys" onclick="append(this.value)">5</button>
                                        <button type="button" value="6" class="col-xs-3 num-keys" onclick="append(this.value)">6</button>
                                        <button type="button" value="7" class="col-xs-3 num-keys" onclick="append(this.value)">7</button>
                                        <button type="button" value="8" class="col-xs-3 num-keys" onclick="append(this.value)">8</button>
                                        <button type="button" value="9" class="col-xs-3 num-keys" onclick="append(this.value)">9</button>
                                        <button type="button" class="col-xs-3 num-keys spl-key" onclick="backspace('field')"><i class="fas fa-backspace"></i></button> 
                                        <button type="button" value="0"  class="num-keys col-xs-3" onclick="append(this.value)">0</button>
                                        <button type="submit" class="num-keys col-xs-3 spl-key" name="addEx"><i class="fas fa-check"></i></button> 
                                    </div>
                                </div>
                                </div>
                            </form>
                          </div>

                        </div>
                      </div>
                    <!-- Modal -->
                     <div class="modal fade" id="addIncome" role="dialog">
                        <div class="modal-dialog">

                          <!-- Modal content-->
                          <div class="modal-content" style="margin-top:20%;">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h3 class="modal-title">Add Income</h3>
                            </div>
                            <form method="post" action="income.php">
                                <div class="modal-body">
                                <div class="row my-form-group">
                                    <div class="col-xs-11 categories-label" onclick="toggleCollapse('categories-body-2')">Select category: <i class="fas fa-th"></i></div>

                                    <div id="categories-body-2" class="categories col-xs-12">
                                       <?php
                                        foreach($cat as $c) {
                                            if($c['type']=='I') {
                                        ?>
                                            <div class="col-xs-4 col-sm-3">
                                                <label class="radio-container"><i class="<?php echo $c['name']; ?>" style="color:<?php echo $c['color']; ?>"></i>
                                                  <center><p><?php echo $c['title']; ?></p></center>
                                                  <input type="radio" value="<?php echo $c['id']; ?>" name="category" required>
                                                  <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="col-xs-5 col-xs-offset-1" style="margin-top:5px;">
                                        <select name="account" class="form-control" required>
                                            <option value="" disabled selected>Select Account</option>
                                            <option value="cash">Cash</option>
                                            <option value="bank">Bank Account</option>
                                            <option value="other">Other Wallet</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-10 col-xs-offset-1" style="margin-top:5px;margin-bottom:10px;">
                                        <input id="field2" type="tel"  pattern="[0-9]+" title="Numeric values only." class="form-control" placeholder="$ Amount" name="amount" required>
                                    </div>
                                    <div class="col-xs-10 col-xs-offset-1 numpad">
                                        <button type="button" value="1" class="col-xs-3 num-keys" onclick="append2(this.value)">1</button>
                                        <button type="button" value="2" class="col-xs-3 num-keys" onclick="append2(this.value)">2</button>
                                        <button type="button" value="3" class="col-xs-3 num-keys" onclick="append2(this.value)">3</button>
                                        <button type="button" value="4" class="col-xs-3 num-keys" onclick="append2(this.value)">4</button>
                                        <button type="button" value="5" class="col-xs-3 num-keys" onclick="append2(this.value)">5</button>
                                        <button type="button" value="6" class="col-xs-3 num-keys" onclick="append2(this.value)">6</button>
                                        <button type="button" value="7" class="col-xs-3 num-keys" onclick="append2(this.value)">7</button>
                                        <button type="button" value="8" class="col-xs-3 num-keys" onclick="append2(this.value)">8</button>
                                        <button type="button" value="9" class="col-xs-3 num-keys" onclick="append2(this.value)">9</button>
                                        <button type="button" class="col-xs-3 num-keys spl-key" onclick="backspace('field2')"><i class="fas fa-backspace"></i></button> 
                                        <button type="button" value="0"  class="num-keys col-xs-3" onclick="append2(this.value)">0</button>
                                        <button type="submit" class="num-keys col-xs-3 spl-key" name="addInc"><i class="fas fa-check"></i></button> 
                                    </div>
                                </div>
                                </div>
                            </form>
                          </div>

                        </div>
                      </div>  
                </center>
            </div>
        </div>
    </div>
    
    <div class="container" id="content2">
        <div class="row">
           <?php
            foreach($expense as $e) {
                $c=category_data($e['category'], "icon", "title", "color", "type");
                if($sum==0) {
                    $percent=0;
                }
                else {
                    $percent=round(($e['amount']/$sum)*100,1,PHP_ROUND_HALF_UP);
                }
            ?>
            <div class="col-sm-6 col-xs-12">
                <span style="font-weight:700;" class="info" data-toggle="modal" data-target="#category<?php echo $e['category']; ?>" ><i class="<?php echo $c['icon']; ?>" style="font-size:2em;color:<?php echo $c['color']; ?>"></i> <?php echo $c['title']; ?></span>
                <div class="dg-loadlist11 pt-20">
                    <div class="progress">
                        <div class='bar animation animationwidth' data-width='<?php echo $percent; ?>%' style="background-color:<?php echo $c['color']; ?>"><span>0</span></div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
    
    
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/Chart.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/theme-functions.js"></script>
<script>
    var ctx = document.getElementById("myDoughnut").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [
            <?php
            foreach($expense as $e) {
                $c=category_data($e['category'], "icon", "title", "color", "type");
                echo "'".$c['title']."',";
            }
            ?>
        ],
        datasets: [{
          backgroundColor: [
            <?php
            foreach($expense as $e) {
                $c=category_data($e['category'], "icon", "title", "color", "type");
                echo "'".$c['color']."',";
            }
            ?>
          ],
          borderWidth: [
            <?php
            foreach($expense as $e) {
                $c=category_data($e['category'], "icon", "title", "color", "type");
                echo "3,";
            }
            ?>
          ],
          hoverBorderWidth: [
            <?php
            foreach($expense as $e) {
                $c=category_data($e['category'], "icon", "title", "color", "type");
                echo "0,";
            }
            ?>
          ],
          borderColor: [
            <?php
            foreach($expense as $e) {
                $c=category_data($e['category'], "icon", "title", "color", "type");
                echo "'#fafafa',";
            }
            ?>
          ],
          data: [
            <?php
            if($sum==0) {
                echo "1,";
            }
            else {
                foreach($expense as $e) {
                    echo "'".$e['amount']."',";
                }
            }
            ?>
          ]
        }]
      },
      options: {
        responsive: true,
        legend: false,
        title: {
            display: true,
            position: "bottom",
            text: 'Expense: <?php echo $sum; ?>'
        },
        centertext1: "Balance:",
        centertext2: "<?php echo $user['total_balance']; ?>",
        rotation: -0.5 * Math.PI,
        circumference: 2 * Math.PI,
        cutoutPercentage: <?php echo (($sum==0)? '92' : '50'); ?>,        //default value is 50
//        legend: {
//            position: 'bottom',
//            labels: {
//                boxWidth: 20,
//                fontStyle: 'bold'
//            }
//        },
      }
    });
    Chart.pluginService.register({
        beforeDatasetsDraw: function (chart) {
            if (chart.options.centertext1) {
                var width = chart.chart.width,
                        height = chart.chart.height,
                        ctx = chart.chart.ctx;

                ctx.restore();
                var fontSize = (height / 300).toFixed(2); // was: 114
                ctx.font = fontSize + "em sans-serif";
                ctx.textBaseline = "middle";

                var text = chart.options.centertext1, // "75%",
                        textX = Math.round((width - ctx.measureText(text).width) / 2),
                        textY = height / 2 - (chart.titleBlock.height - 2);

                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }
    });
    Chart.pluginService.register({
        beforeDatasetsDraw: function (chart) {
            if (chart.options.centertext2) {
                var width = chart.chart.width,
                        height = chart.chart.height,
                        ctx = chart.chart.ctx;

                ctx.restore();
                var fontSize = (height / 120).toFixed(2); // was: 114
                ctx.font = fontSize + "em sans-serif";
                ctx.textBaseline = "middle";

                var text = chart.options.centertext2, // "75%",
                        textX = Math.round((width - ctx.measureText(text).width) / 2),
                        textY = height / 2 - (chart.titleBlock.height - 26);

                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }
    });
</script>

</body>
</html>