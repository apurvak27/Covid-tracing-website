<?php
if(session_status() === PHP_SESSION_ACTIVE){
    session_destroy();
}
$dbjson = file_get_contents("data.json");
$dbinfo = json_decode($dbjson);
$content = file_get_contents('login.html');
echo $content;
if(isset($_POST['submit'])){
    session_start();
    $username = htmlspecialchars($_REQUEST['username']);
    $password =htmlspecialchars($_REQUEST['password']);
    $conn = new mysqli($dbinfo->servername, $dbinfo->username, $dbinfo->password,$dbinfo->dbname);
    if($conn -> connect_error){
        die("Connection failed" . $conn->connect_error);
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $result = $conn->query("SELECT * FROM user_info WHERE username = '$username'");
    
    $rows = $result->fetch_assoc();
    $valid = $rows['password'];
    if($result== FALSE ){
        echo "Error";
    }else{
        if(password_verify($password, $valid)){
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $rows['id'];
            header('Location: ./home.php');
        }else{
            echo "Error!";
        }


        $conn->close();
}


}

?>

