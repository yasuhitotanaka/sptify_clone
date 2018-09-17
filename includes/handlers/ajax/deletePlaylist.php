<?php
  include("../../config.php");

  if(isset($_POST['playlistID'])) {

    $playlistID = $_POST['playlistID'];

    $playlistQuery = mysqli_query($connection, "DELETE FROM playlists WHERE id='$playlistID'");
    $playlistSongQuery = mysqli_query($connection, "DELETE FROM playlistsongs WHERE playlistID='$playlistID'");

  } else {
    echo "PlaylistID was not passed into deletePlaylist.php";
  }
?>
