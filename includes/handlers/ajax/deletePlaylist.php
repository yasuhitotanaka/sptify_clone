<?php
  include("../../config.php");

  if(isset($_POST['playlistID'])) {

    $playlistID = $_POST['playlistID'];

    $query = mysqli_query($connection, "DELETE FROM playlists WHERE id='$playlistID'");
    $query = mysqli_query($connection, "DELETE FROM playlistsongs WHERE playlistID='$playlistID'");

  } else {
    echo "Name or username parameters not passed into file";
  }
?>
