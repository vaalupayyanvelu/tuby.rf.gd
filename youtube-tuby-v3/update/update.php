<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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

$updatId = $_GET['updateId'];

if (isset($_GET['update'])){
  $valuesSql = "SELECT `url`,`tags`, `sequence` FROM tuby3 WHERE sequence = $updatId";
  $values =  $conn->query($valuesSql);
}

if ($values->num_rows>0) {
    $row = $values->fetch_assoc();
        echo'
        <form action="action.php" method="post">
            <label for="url">URL :</label><br/>
            <input type="text" name="url" id="url" value="'.$row['url'].'"><br/>
            <label for="tags"> Tags :</label><br/>
            <input type="text" name="tags" id="tags" value="'.$row['tags'].'"><br/>
            <input type="number" name="sequence" id="sequence" value="'.$row['sequence'].'" hidden><br/>

            <input type="submit" value="Submit">
        </form>
        ';
  }

$conn->close();

?>

</body>
</html>