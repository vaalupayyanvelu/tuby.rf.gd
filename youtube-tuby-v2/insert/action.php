<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv = "refresh" content = "0; url = http://tuby.rf.gd/youtube-tuby-v2/index.php#footer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./test.css">
    <title>Document</title>
</head>
<body>
  
<?php
$servername="sql207.epizy.com";
$username="epiz_29743151";
$password="hZ8nAgMZV1M5g";
$dbname="epiz_29743151_tuby_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed : " . $conn->connect_error);
}
$url = $_REQUEST['url'];
$tags = $_REQUEST['tags'];
$sql = "INSERT INTO tuby2 VALUES ('$url', '$tags')";
  
if ($conn->query($sql) === TRUE) {
    echo "Record inserted successfully.....
    Redirecting to <a href='http://tuby.rf.gd/youtube-tuby-v2/index.php#footer/'>Home</a>
    ";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>

</body>
</html>