<?php
function insert_expense($uid,$amount,$category,$description,$account,$timestamp,$date,$month,$year){
    global $db;
    $query="insert into expense (uid,category,description,amount,account,timestamp,date,month,year) values ('$uid','$category','$description' ,'$amount','$account','$timestamp','$date','$month','$year')";
    $result=mysqli_query($db,$query);
    if(!$result){
        die("error");
    }
    if($account=='cash')
    $query="update users set total_balance = total_balance - $amount, cash=cash-$amount where uid = $uid";
    else if($account=='bank')
    $query="update users set total_balance = total_balance - $amount, bank=bank-$amount where uid = $uid";
    else if($account=='other')
    $query="update users set total_balance = total_balance - $amount, other=other-$amount where uid = $uid";
    if(!mysqli_query($db,$query)) {
        die("error updating : ".$db->error);
    }
}

function ex_category_data($c) {
    $data = array();
    global $db;
    $query="select * from expense where uid=".$_SESSION['uid']." and `category`=$c";
    $result=mysqli_query($db, $query);
    if(!$result) {
        die("Error fetching expense : ".$db->error);
    }
    else {
        if($result->num_rows !=0) {
            while($row=mysqli_fetch_assoc($result)) {
                if($row['description']==null || $row['description']=="") {
                    $row['description']="-N/A-";
                }
                array_push($data, array('expense_id'=>$row['expense_id'], 'description'=>$row['description'], 'amount'=>$row['amount'], 'account'=>$row['account'], 'timestamp'=>$row['timestamp'], 'date'=>$row['date'], 'month'=>$row['month'], 'year'=>$row['year']));
            }
        }
    }
    return $data;
}

function monthStatsExpense($month,$year) {
    $expense = array();
    global $db;
    $query="select category, sum(amount) as sum from expense where uid=".$_SESSION['uid']." and `month`=$month and `year`=$year group by category";
    $result=mysqli_query($db, $query);
    if(!$result) {
        die("Error fetching expense : ".$db->error);
    }
    else {
        if($result->num_rows !=0) {
            while($row=mysqli_fetch_assoc($result)) {
                array_push($expense, array('category'=>$row['category'], 'amount'=>$row['sum']));
            }
        }
        else{
            array_push($expense, array('category'=>0, 'amount'=>0));
        }
    }
    return $expense;
}

function dateStatsExpense($date,$month,$year){
    $expense = array();
    global $db;
    $query="select category, sum(amount) as sum from expense where uid=".$_SESSION['uid']." and `date`=$date and `month`=$month and `year`=$year group by category";
    $result=mysqli_query($db, $query);
    if(!$result) {
        die("Error fetching expense : ".$db->error);
    }
    else {
        if($result->num_rows !=0) {
            while($row=mysqli_fetch_assoc($result)) {
                array_push($expense, array('category'=>$row['category'], 'amount'=>$row['sum']));
            }
        }
        else{
            array_push($expense, array('category'=>0, 'amount'=>0));
        }
    }
    return $expense;
}

function yearStatsExpense($year){
    $expense = array();
    global $db;
    $query="select category, sum(amount) as sum from expense where uid=".$_SESSION['uid']." and `year`=$year group by category";
    $result=mysqli_query($db, $query);
    if(!$result) {
        die("Error fetching expense : ".$db->error);
    }
    else {
        if($result->num_rows !=0) {
            while($row=mysqli_fetch_assoc($result)) {
                array_push($expense, array('category'=>$row['category'], 'amount'=>$row['sum']));
            }
        }
        else{
            die("no data on this year".$year);
        }
    }
    return $expense;
}

function durationStatsExpense($timestamp1,$timestamp2){
    $expense = array();
    global $db;
    $query="select category, sum(amount) as sum from expense where uid=".$_SESSION['uid']." and timestamp between $timestamp1 and $timestamp2 group by category";
    $result=mysqli_query($db, $query);
    if(!$result) {
        die("Error fetching expense : ".$db->error);
    }
    else {
        if($result->num_rows !=0) {
            while($row=mysqli_fetch_assoc($result)) {
                array_push($expense, array('category'=>$row['category'], 'amount'=>$row['sum']));
            }
        }
        else{
            die("no data on this year".$year);
        }
    }
    return $expense;
}


?> 