<?php
session_start();
$content = file_get_contents('report.html');
$dbjson = file_get_contents("data.json");
$dbinfo = json_decode($dbjson);
echo $content;
if (isset($_POST['submit'])) {

    $date = htmlspecialchars($_REQUEST['date']);
    $time = htmlspecialchars($_REQUEST['time']);
    $id = $_SESSION["id"];
    $conn = new mysqli($dbinfo->servername, $dbinfo->username, $dbinfo->password, $dbinfo->dbname);
    if ($conn->connect_error) {
        die("Connection failed" . $conn->connect_error);
    }

    $id = $_SESSION['id'];
    $sql = "SELECT date,time,duration,x,y,id FROM visits WHERE id = '$id'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data = array(
                "x" => $row['x'],
                "y" => $row['y'],
                "date" => $row['date'],
                "time" => $row['time'] . ":00",
                "duration" => $row['duration']
            );
            $this_id = $row['id'];
            $this_date = $row['date'];
            $this_time = $row['time'];
            $sql2 = "INSERT INTO infections (this_id, this_date, this_time) VALUES ('$id', '$this_date', '$this_time')";
            $conn->query($sql2);
            $ch = curl_copy_handle();
            $endresult = curl_exec($ch);
        }

    }
}
?>



