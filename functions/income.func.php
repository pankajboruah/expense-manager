<?php

function insert_income($uid,$amount,$category,$account,$timestamp,$date,$month,$year){
    global $db;
    $query="insert into income (uid,category,amount,account,timestamp,date,month,year) values ('$uid','$category','$amount','$account','$timestamp','$date','$month','$year')";
    $result=mysqli_query($db,$query);
    if(!$result){
        die("error");
    }
    if($account=='cash')
    $query="update users set total_balance = total_balance + $amount, cash=cash+$amount where uid = $uid";
    else if($account=='bank')
    $query="update users set total_balance = total_balance + $amount, bank=bank+$amount where uid = $uid";
    else if($account=='other')
    $query="update users set total_balance = total_balance + $amount, other=other+$amount where uid = $uid";
    if(!mysqli_query($db,$query)) {
        die("error updating : ".$db->error);
    }
}

function inc_category_data($c) {
    $data = array();
    global $db;
    $query="select * from income where uid=".$_SESSION['uid']." and `category`=$c";
    $result=mysqli_query($db, $query);
    if(!$result) {
        die("Error fetching income : ".$db->error);
    }
    else {
        if($result->num_rows !=0) {
            while($row=mysqli_fetch_assoc($result)) {
                array_push($data, array('income_id'=>$row['income_id'], 'amount'=>$row['amount'], 'account'=>$row['account'], 'timestamp'=>$row['timestamp'], 'date'=>$row['date'], 'month'=>$row['month'], 'year'=>$row['year']));
            }
        }
    }
    return $data;
}

function monthStatsIncome($month,$year) {
    $income = array();
    global $db;
    $query="select category, sum(amount) as sum from income where uid=".$_SESSION['uid']." and `month`=$month and `year`=$year group by category";
    $result=mysqli_query($db, $query);
    if(!$result) {
        die("Error fetching income : ".$db->error);
    }
    else {
        if($result->num_rows !=0) {
            while($row=mysqli_fetch_assoc($result)) {
                array_push($income, array('category'=>$row['category'], 'amount'=>$row['sum']));
            }
        }
        else{
            array_push($income, array('category'=>0, 'amount'=>0));
        }
    }
    return $income;
}

function dateStatsIncome($date,$month,$year){
    $income = array();
    global $db;
    $query="select category, sum(amount) as sum from income where uid=".$_SESSION['uid']." and `date`=$date and `month`=$month and `year`=$year group by category";
    $result=mysqli_query($db, $query);
    if(!$result) {
        die("Error fetching income : ".$db->error);
    }
    else {
        if($result->num_rows !=0) {
            while($row=mysqli_fetch_assoc($result)) {
                array_push($income, array('category'=>$row['category'], 'amount'=>$row['sum']));
            }
        }
        else{
            array_push($income, array('category'=>0, 'amount'=>0));
        }
    }
    return $income;
}

function yearStatsIncome($year){
    $income = array();
    global $db;
    $query="select category, sum(amount) as sum from income where uid=".$_SESSION['uid']." and `year`=$year group by category";
    $result=mysqli_query($db, $query);
    if(!$result) {
        die("Error fetching income : ".$db->error);
    }
    else {
        if($result->num_rows !=0) {
            while($row=mysqli_fetch_assoc($result)) {
                array_push($income, array('category'=>$row['category'], 'amount'=>$row['sum']));
            }
        }
        else{
            array_push($income, array('category'=>0, 'amount'=>0));
        }
    }
    return $income;
}

function durationStatsIncome($timestamp1,$timestamp2){
    $income = array();
    global $db;
    $query="select category, sum(amount) as sum from Income where uid=".$_SESSION['uid']." and timestamp between $timestamp1 and $timestamp2 group by category";
    $result=mysqli_query($db, $query);
    if(!$result) {
        die("Error fetching income : ".$db->error);
    }
    else {
        if($result->num_rows !=0) {
            while($row=mysqli_fetch_assoc($result)) {
                array_push($income, array('category'=>$row['category'], 'amount'=>$row['sum']));
            }
        }
        else{
            array_push($income, array('category'=>0, 'amount'=>0));
        }
    }
    return $income;
}

?>