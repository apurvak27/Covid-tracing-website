<?php
session_start();
$content = file_get_contents('settings.html');
$dbjson = file_get_contents("data.json");
$dbinfo = json_decode($dbjson);

echo $content;
if (isset($_POST['submit'])) {
    $window = htmlspecialchars($_REQUEST["window"]);
    $distance = htmlspecialchars($_REQUEST["distance"]);
    $windowcookie = "window";
    $distancecookie = "distance";
    //86400 is equal to 1 day
    setcookie($windowcookie, $window, time() + (86400 * 30), "/");
    setcookie($distancecookie, $distance, time() + (86400 * 30), "/");
    if(!isset($windowcookie)){
        echo "Cookie named '". $window." ' is not set!";
    }
    if(!isset($distancecookie)){
        echo "Cookie named '". $distance." ' is not set!";
    }

}
?>


