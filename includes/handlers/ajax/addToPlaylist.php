<?php
include("../../config.php");

if(isset($_POST['playlistID']) && isset($_POST['songID'])) {
  $playlistID = $_POST['playlistID'];
  $songID = $_POST['songID'];

  $orderIDQuery = mysqli_query($connection, "SELECT MAX(playlistOrder) as playlistOrder FROM playlistsongs WHERE playlistID='$playlistID'");
  $row = mysqli_fetch_array($orderIDQuery);
  $order = $row['playlistOrder'] + 1;

  $query = mysqli_query($connection, "INSERT INTO playlistsongs VALUES('','$songID','$playlistID','$order')");

  } else {
    echo "PlaylistID or songID was not passed into addToPlaylist.php";
  }
?>
