<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/youtube-tuby-v3/resources/stylesheet.css">
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

  //To fetch tags links
  $tagsQuery = "SELECT tags FROM tuby3";
  $tagsResult = $conn->query($tagsQuery);
  $tagsArray = array();
  $tagsSingle = array();

  while ($tagsRow = $tagsResult->fetch_assoc()) {
    $tagsArray[] = $tagsRow['tags'];
  }

  for ($i = 0; $i < count($tagsArray); $i++) {
    $splitted = explode(",", $tagsArray[$i]);
    for ($j = 0; $j < count($splitted); $j++) {
      $tagsSingle[] = $splitted[$j];
    }
  }

  $tagsUnique = array_unique($tagsSingle);

  if (isset($_GET['hello'])) {
    $tagMeow = $_GET['meow'];
    $sql = "SELECT `url`,`tags` FROM tuby3 WHERE tags LIKE '%$tagMeow%'";
  } else {
    $sql = "SELECT `url`,`tags` FROM tuby3";
  }

  $result = $conn->query($sql);

  echo '<div id="navbar">';
  echo '<a href="/youtube-tuby-v3/index.php">Home</a>';
  
  echo '<select id="tags"><option>- Select -</option>';
  for ($i = 0; $i < count($tagsSingle); $i++) {
    if ($tagsUnique[$i]) { //To filter the empty array values
      if($tagsUnique[$i] == $_GET['meow']){ //For Default value in Select
        echo '<option value="/youtube-tuby-v3/index.php?hello=true&meow=' . $tagsUnique[$i] . '" selected>' . $tagsUnique[$i] . '</option>';
      }
      else{
        echo '<option value="/youtube-tuby-v3/index.php?hello=true&meow=' . $tagsUnique[$i] . '">' . $tagsUnique[$i] . '</option>';
      }
    }
  }

  echo '</select>
  <a href="/youtube-tuby-v3/insert/form.html" style="float:right;"> Insert </a>
  </div>';

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
      //For dropdown
    document.getElementById("tags").onchange = function() {
      if (this.selectedIndex !== 0) {
        window.location.href = this.value;
      }
    };
</script>
</body>
</html>