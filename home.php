<?php
session_start();
$dbjson = file_get_contents("data.json");
$dbinfo = json_decode($dbjson);
?>
<html>
    <title>COVID - 19 Contact Tracing</title>
    <link rel="stylesheet" href="home.css">
    <script>
        function addMarker(x, y){
            var image = document.createElement("IMG");
            image.src = "marker_red.png";
            image.style.top = (y -image.height) + 'px';
            image.style.left = (x - (image.width/3)) + 'px';
            image.id = "marker";
            image.onclick= function(){giveDetails(x,y)};
            var parent = document.getElementById("grid_display");
            parent.appendChild(image);
        }
        function addMarkerBlack(x, y){
            var image = document.createElement("IMG");
            image.src = "marker_black.png";
            image.style.top = (y -image.height) + 'px';
            image.style.left = (x - (image.width/3)) + 'px';
            image.id = "marker";
            image.onclick= function(){giveDetails(x,y)};
            var parent = document.getElementById("grid_display");
            parent.appendChild(image);
        }
        function giveDetails(x,y){
            document.getElementById("message").innerHTML = "X:" + x + "\nY:"+ y;
            console.log("click");
        }
    </script>
</head>
<body>

<div class="leftmenu">
    <a href="home.php">Home</a>
    <br>
    <a href="overview.php">Overview</a>
    <br>
    <a href="addvisit.php">Add Visit</a>
    <br>
    <a href="report.php">Report</a>
    <br>
    <a href="settings.php">Settings</a>
    <br>
    <a href="index.php">Logout</a>
</div>

<div class="left_side">
    <div id="website_background">
        <h1 id="title">
            COVID - 19 Contact Tracing
        </h1>
    </div>
    <p id="heading">Status</p>
    <img class="watermark_image" src="watermark.png">
    <hr class="Line">
    <div id="map_display">

        <p class="description">Hi <?php session_start(); echo $_SESSION['username']; ?>, you might have <br> had a connection to<br> the infected person at the <br>location shown in red</p>
        <p id = "message" class= "description" ></p>
        <p class="instructions">Click on the marker to see<br> details about the infection.</p>

        <div id="grid_display">
            <img class="map" id="map"src="exeter.jpeg">
            <?php

            $dbjson = file_get_contents("data.json");
            $dbinfo = json_decode($dbjson);

            $sql = "SELECT id FROM infections;";
            $conn = new mysqli($dbinfo->servername, $dbinfo->username, $dbinfo->password,$dbinfo->dbname);
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $infectionid = $row['id'];
                    $sql2 = "SELECT date,time,duration,x,y FROM visits WHERE id = '$infectionid'";
                    $result2 = $conn->query($sql2);
                    if($result2->num_rows >0){
                        //print all
                        while($row2 = $result2->fetch_assoc()){
                            echo "<script>addMarkerBlack(".$row2['x'].",".$row2['y'].")</script>";
                        }
                    }
                }
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $endresult = curl_exec($ch);
            $arr = json_decode($endresult, true);
            $distance = $_COOKIE["distance"];
            foreach($arr as &$value){
                echo "<script>addMarkerBlack(".$value['x'].",".$value['y'].")</script>";
                foreach($arr as &$value2){
                    if(sqrt(pow(($value['x']-$value['y']),2)+pow(($value2['x']-$value2['y']),2)) <= $distance){
                        echo "<script>addMarker(".$value['x'].",".$value['y'].")</script>";
                    }
                }
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>
