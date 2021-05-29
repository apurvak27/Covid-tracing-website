<?php
$content = file_get_contents('registration.html');
$dbjson = file_get_contents("data.json");
$dbinfo = json_decode($dbjson);

echo $content;
if(isset($_POST['submit'])){
  session_start();
    
    $name = htmlspecialchars($_REQUEST['name']);
    $surname =  htmlspecialchars($_REQUEST['surname']);
    $username = htmlspecialchars($_REQUEST['username']);
    $password = htmlspecialchars($_REQUEST['password']));
    $conn = new mysqli($dbinfo->dbservername, $dbinfo->username, $dbinfo->password,$dbinfo->dbname);
    if($conn -> connect_error){
        die("There has been a connection failure" . $conn->connect_error);
    }
    $sql = "INSERT INTO user_data(name, surname,username,password) VALUES (?, ?, ?, ?)";

    $statement = mysqli_stmt_init($conn);
    }
      $query = $conn->prepare($sql);
      $query->bind_param("ssss", $name, $surname, $username, $password);
      $query->execute();
      
      header('Location: ./index.php');
  
?>










