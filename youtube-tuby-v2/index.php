<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/youtube-tuby-v2/resources/stylesheet.css">
    <title>Document</title>
</head>
<body>
<div class="div-center" style="padding :2%;">
  <h1> Welcome !</h1>
</div>
<div id="navbar">
    <a href="/">Link 1</a>
    <a href="/">Link 2</a>
    <a href="/">Link 3</a>
</div>

<?php
$servername="sql207.epizy.com";
$username="epiz_29743151";
$password="hZ8nAgMZV1M5g";
$dbname="epiz_29743151_tuby_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed : " . $conn->connect_error);
}

$apikey = "AIzaSyB1cwxevl-znX-D-wgGno0HLyAH_s61rFc";

//Method to get the Duration of video.
function getDuration($videoID, $apikey){
  $dur = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=$videoID&key=$apikey");
  $VidDuration =json_decode($dur, true);
  foreach ($VidDuration['items'] as $vidTime){
      $VidDuration= $vidTime['contentDetails']['duration'];
  }
  preg_match_all('/(\d+)/',$VidDuration,$parts);
  return $parts[0][0] . ":" . $parts[0][1]; // Return MM:SS
}

//Method to get the title of video
function getTitle($videoID, $apikey){
  $url = "https://www.googleapis.com/youtube/v3/videos?id=" . $videoID . "&key=" . $apikey . "&part=snippet,contentDetails,statistics,status";
  $json = file_get_contents($url);
  $getData = json_decode( $json , true);
  foreach((array)$getData['items'] as $key => $gDat){
      $title = $gDat['snippet']['title'];
  }
  return $title;
}

//Method to get thumbnail of the video
function getThumbnail($videoID){
  $thumbnail_url = "https://i.ytimg.com/vi/".$videoID."/mqdefault.jpg";
  return $thumbnail_url;
}

$sql = "SELECT * FROM tuby2";
$result = $conn->query($sql);
echo '<div class="thumbnail-container">';
if ($result->num_rows>0) {
  while ($row = $result->fetch_assoc()) {

    $toSplit = explode('=', $row['url']);
    $videoID = $toSplit[1];

    $title = getTitle($videoID, $apikey);
    $url = $row['url'];
    $thumbnail_url = getThumbnail($videoID);
    $duration = getDuration($videoID, $apikey);
    $tags = $row['tags'];

    echo '
    <div class="thumbnail-div"><img src = "'.$thumbnail_url.'" class="thumbnail" />
    <br/><a href="'.$url.'" style="font-size: 80%; text-decoration: none;">'.$title.'</a><br/>
    <span class="tags">' .$tags.'</span>
    <span class="duration">'.$duration.'</span></div>';
     
  }
}
else {
  echo "No results maame ";
}
echo '</div>';

$conn->close();
?>

<div id= "footer">
</div>
<script>
//For Sticky Nav Bar
window.onscroll = function() {
    myFunction()
};
var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;
function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
</script>
</body>
</html>
    
   