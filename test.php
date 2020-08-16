<?php
include "init.php";

$icons=array(
            "fab fa-accessible-icon",
            "fab fa-algolia",
            "fas fa-ambulance",
            "fab fa-android",
            "fas fa-assistive-listening-systems",
            "far fa-snowflake",
            "fas fa-tint",
            "fas fa-balance-scale",
            "fas fa-basketball-ball",
            "fas fa-bed",
            "fas fa-beer",
            "fas fa-bell",
            "fas fa-bicycle",
            "fas fa-binoculars",
            "fas fa-birthday-cake",
            "fas fa-gift",
            "fab fa-bitcoin",
            "fas fa-money-bill-wave",
            "fab fa-bity",
            "fab fa-black-tie",
            "fab fa-bluetooth",
            "fas fa-blender",
            "fas fa-blind",
            "fas fa-bolt",
            "fas fa-bowling-ball",
            "fas fa-paw",
            "fas fa-bookmark",
            "fas fa-briefcase-medical",
            "fas fa-briefcase",
            "fas fa-broadcast-tower",
            "fas fa-brush",
            "fas fa-building",
            "fas fa-bus-alt",
            "fas fa-calculator",
            "fas fa-calendar-alt",
            "fas fa-camera-retro",
            "fas fa-cannabis",
            "fas fa-capsules",
            "fas fa-car",
            "fas fa-cart-arrow-down",
            "fas fa-shopping-basket",
            "fas fa-shopping-bag",
            "fas fa-shopping-cart",
            "fas fa-chalkboard-teacher",
            "fas fa-chart-pie",
            "fas fa-chess",
            "fas fa-chess-knight",
            "fas fa-child",
            "fas fa-church",
            "fas fa-school",
            "fas fa-home",
            "fas fa-bath",
            "fas fa-circle",
            "fas fa-clipboard-list",
            "fas fa-clock",
            "fas fa-clone",
            "fas fa-cocktail",
            "fas fa-code-branch",
            "fas fa-stethoscope",
            "fas fa-coffee",
            "fas fa-cog",
            "fas fa-coins",
            "fas fa-concierge-bell",
            "fas fa-cookie-bite",   
            "fas fa-couch",
            "fas fa-crow",
            "fas fa-dove",
            "fas fa-crown",
            "fas fa-cut",
            "fas fa-desktop",
            "fas fa-dna",
            "fas fa-tag",
            "fas fa-file-invoice-dollar",
            "fas fa-receipt",
            "fas fa-dollar-sign",
            "fas fa-rupee-sign",
            "fas fa-donate",
            "fas fa-drum",
            "fab fa-earlybirds",
            "fas fa-envelope",
            "fab fa-envira",
            "fas fa-eye",
            "fas fa-fighter-jet",
            "fas fa-fingerprint",
            "fas fa-fish",
            "fas fa-gamepad",
            "fas fa-glasses",
            "fab fa-gulp",
            "fas fa-hand-holding-usd",
            "fas fa-grin-wink",
            "fas fa-heartbeat",
            "fas fa-hand-holding-heart",
            "fas fa-headphones-alt",
            "fas fa-headset",
            "fas fa-hospital",
            "fas fa-hotel",
            "fas fa-music",
            "fas fa-laptop",
            "fas fa-microphone-alt",
            "fas fa-mobile-alt",
            "fas fa-motorcycle",
            "fas fa-paint-brush",
            "fas fa-pills",
            "fas fa-piggy-bank",
            "fas fa-plane",
            "fab fa-avianex",
            "fas fa-phone-volume",
            "fas fa-smoking",
            "fas fa-subway",
            "fas fa-swimmer",
            "fas fa-taxi",
            "fas fa-tshirt",
            "fas fa-user-md",
            "fas fa-utensils",
            "fas fa-volleyball-ball",
            "fas fa-umbrella",            
            "fab fa-sticker-mule"            
            );
$query="select * from icons";
$result=mysqli_query($db, $query);
if($result->num_rows==0) {
    foreach($icons as $i) {
        $query="insert into icons(name) values('$i')";
        if(!mysqli_query($db, $query)) {
            die("insert icon failed: ".$db-error);
        }
    }
    echo "DONE!";
    
    
$cat=array();
array_push($cat, array('title'=>"Bills",'name'=>"fas fa-file-invoice-dollar",'color'=>" #16b76e",'type'=>"E"));
array_push($cat, array('title'=>"Car",'name'=>"fas fa-car",'color'=>"#ffff54",'type'=>"E"));
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
array_push($cat, array('title'=>"School",'name'=>"fas fa-school",'color'=>"#d77aff",'type'=>"E"));
array_push($cat, array('title'=>"Taxi",'name'=>"fas fa-taxi",'color'=>"#90ff79",'type'=>"E"));
array_push($cat, array('title'=>"Toiletry",'name'=>"fas fa-bath",'color'=>"##3d436b",'type'=>"E"));
array_push($cat, array('title'=>"Transport",'name'=>"fas fa-bus-alt",'color'=>"#ad53d1",'type'=>"E"));
array_push($cat, array('title'=>"Deposits",'name'=>"fas fa-donate",'color'=>"#3e8ad6",'type'=>"I"));
array_push($cat, array('title'=>"Salary",'name'=>"fas fa-money-bill-wave",'color'=>"#62c13a",'type'=>"I"));
array_push($cat, array('title'=>"Savings",'name'=>"fas fa-piggy-bank",'color'=>"#ef3502",'type'=>"I"));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>icons</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <style>
        i:hover {
            background: #a3ffd5;
        }
    </style>
</head>
<body>
    <?php
    foreach($icons as $i) {
        echo "<i class='$i col-md-1' style='font-size:3em;margin:0.3%'></i>";
    }
    if(isset($_GET['d'])) {
        die($_GET['d']);
    }
    ?>
    <form action="" method="get">
      <input type="date" name="d">
      <input type="submit">
    </form>
</body>
</html>