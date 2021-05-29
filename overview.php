<?php
session_start();
$dbjson = file_get_contents("data.json");
$dbinfo = json_decode($dbjson);
?>
<html>
    <title>COVID - 19 Contact Tracing</title>
    <link rel="stylesheet" href="overview.css">
    <script>
        function deleteRow(elem){
            var table = elem.parentNode.parentNode.parentNode;
            var rowCount = table.rows.length;
            var row = elem.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }
        function deleteRowFromDataBase(id){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log("Good");
                }
            };
            xmlhttp.open("GET", "delete.php?q=" + id, true);
            xmlhttp.send();
        }
    </script>
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

</div>
<div class="left_side">
    <div id="website_background">
        <h1 id="title">
            COVID - 19 Contact Tracing
        </h1>
    </div>
    <img class="watermark_image" src="watermark.png">
    <?php
    $conn = new mysqli($dbinfo->servername, $dbinfo->username, $dbinfo->password,$dbinfo->dbname);
    $id = $_SESSION["id"];
    $sql = "SELECT date,time,duration,x,y,visitid FROM visits WHERE id = '$id'";
    $result = $conn->query($sql);
    echo "<table><tr><th>Date</th><th>Time</th><th>Duration</th><th>X</th><th>Y</th></tr>";
    ?>
</div>
</body>
</html>
