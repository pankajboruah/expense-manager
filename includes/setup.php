<?php 
$db1=mysqli_connect("localhost", "root", "", "mysql");
$q1="create database if not exists arbre_expense";
if(!mysqli_query($db1, $q1)) {
    die("Database creation failed: ".$db1->error);
}
$db1->close();
$db1=mysqli_connect("localhost", "root", "", "arbre_expense");
$q2="create table if not exists users(uid int auto_increment, email varchar(255), password varchar(255), name varchar(255), phn bigint, total_balance bigint default 0, cash bigint default 0, bank bigint default 0, other bigint default 0, primary key (uid))";
if(!mysqli_query($db1, $q2)) {
    die("Error creating users table : ".$db1->error);
}
$q3="create table if not exists expense(uid int, expense_id int auto_increment, category int, description varchar(255) default null, amount bigint, account varchar(255), timestamp int, date int, month int, year int, primary key (expense_id))";
if(!mysqli_query($db1, $q3)) {
    die("Error creating expense table : ".$db1->error);
}
$q4="create table if not exists income(uid int, income_id int auto_increment, category int, amount bigint, account varchar(255), timestamp int, date int, month int, year int, primary key (income_id))";
if(!mysqli_query($db1, $q4)) {
    die("Error creating income table : ".$db1->error);
}
$q5="create table if not exists category(uid int, id int auto_increment, icon varchar(255), color varchar(255), title varchar(255), type varchar(255), primary key (id))";
if(!mysqli_query($db1, $q5)) {
    die("Error creating category table : ".$db1->error);
}
$q6="create table if not exists icons(id int auto_increment, name varchar(255), primary key (id))";
if(!mysqli_query($db1, $q6)) {
    die("Error creating icons table : ".$db1->error);
}
$q7="create table if not exists transfer(uid int, id int auto_increment, amount bigint, description varchar(255) default null, `from` varchar(255), `to` varchar(255), timestamp int, primary key (id))";
if(!mysqli_query($db1, $q7)) {
    die("Error creating transfer table : ".$db1->error);
}


?>