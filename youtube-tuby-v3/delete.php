<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv = "refresh" content = "0; url =/youtube-tuby-v3/index.php" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "coolbuddy";
    $dbname = "tuby_db";
  
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed : " . $conn->connect_error);
  }

 $delId = $_GET['deleteId'];
 if (isset($_GET['delete'])){
   $deleteSql = "DELETE FROM tuby3 WHERE sequence = $delId";
   $deleteResult =  $conn->query($deleteSql);
 }

 ?>
</body>
</html>