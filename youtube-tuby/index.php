<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/youtube-tuby/resources/stylesheet.css">
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
  die("Connection failed ✕: " . $conn->connect_error);
}
echo "✓";

$sql = "SELECT * FROM test_table";
$result = $conn->query($sql);
echo '<div class="thumbnail-container">';
if ($result->num_rows>0) {
  while ($row = $result->fetch_assoc()) {
    echo '
    <div class="thumbnail-div"><img src = "/youtube-tuby/resources/thumbnails/'.$row['title'].'.webp" class="thumbnail" />
    <br/><a href="'.$row['link'].'" style="font-size: 80%; text-decoration: none;">'.$row['title'].'</a><br/>
    <span class="tags">' .$row['tags'].'</span>
    <span class="duration">'.$row['duration'].'</span></div>'; 
  }
}
else {
  echo "No results maame ";
}
echo '</div>';
$conn->close();
?>
</body>
</html>
    
   