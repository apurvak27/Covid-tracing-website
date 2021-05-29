<?php
session_start();
$dbjson = file_get_contents("data.json");
$dbinfo = json_decode($dbjson);


$num = $_REQUEST['q'];
echo $num;
$conn = new mysqli($dbinfo->servername, $dbinfo->username, $dbinfo->password,$dbinfo->dbname);
if($conn -> connect_error){
    die("Fail in Connection" . $conn->connect_error);
}
$sql = "DELETE FROM visits WHERE visitid = '$num'";
if ($conn->query($sql) === TRUE) {
    echo "Deleting Record";
}

$conn->close();

