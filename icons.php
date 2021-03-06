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
            "fab fa-bitcoin",
            "fas fa-money-bill-wave",
            "fab fa-bity",
            "fab fa-black-tie",
            "fab fa-bluetooth",
            "fas fa-blender",
            "fas fa-blind",
            "fas fa-bolt",
            "fas fa-bowling-ball",
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
            "fas fa-school",
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
}
?>