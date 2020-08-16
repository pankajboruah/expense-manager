<?php

function category_data($c) {
    global $db;
    $id=$c;
    $args = func_get_args();
    unset($args[0]);
    $fields = "`".implode("`, `", $args)."`";
    $query="select $fields from category where uid=".$_SESSION['uid']." and id=".$id;
    $result=mysqli_query($db, $query);
    if(!$result) {
        die("error : ".$db->error);
    }
    $row=mysqli_fetch_assoc($result);
    if($result->num_rows==0) {
        $row['icon']="fas fa-ban";
        $row['title']="NO DATA FOUND";
        $row['color']="#aa0000";
        $row['type']="none";
    }
    foreach($args as $a) {
        $args[$a]=$row[$a];
    }
    return $args;
}

function get_categories() {
    $cat = array();
    global $db;
    $query="select * from category where uid=".$_SESSION['uid'];
    $result=mysqli_query($db, $query);
    if(!$result) {
        die("Error fetching categories : ".$db->error);
    }
    else {
        if($result->num_rows !=0) {
            while($row=mysqli_fetch_assoc($result)) {
                array_push($cat, array('id' => $row['id'], 'title' => $row['title'], 'name' => $row['icon'], 'color' => $row['color'], 'type' => $row['type']));
            }
        }
    }
    return $cat;
}

?>