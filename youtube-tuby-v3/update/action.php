<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv = "refresh" content = "0; url =/youtube-tuby-v3/index.php"/>
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
$url = $_REQUEST['url'];
$tags = $_REQUEST['tags'];
$id = $_REQUEST['sequence'];
$sql = "UPDATE tuby3 SET url ='$url', tags = '$tags' WHERE sequence = '$id' ";
  
if ($conn->query($sql) === TRUE) {
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>

</body>
</html>