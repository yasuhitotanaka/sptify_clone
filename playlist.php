<?php
  include("includes/includedFiles.php");

  if (isset($_GET['id'])) {
    $playlistID = $_GET['id'];
  } else {
    header("Location: indx.php");
  }

  $playlist = new Playlist($connection, $playlistID);
  $owner = new User($connection, $playlist->getOwner());
 ?>

<div class="entityInfo">
  <div class="leftSection">
    <div class="playlistImage">
      <img src="assets/images/icons/playlist.png" alt="playlist">
    </div>
  </div>

  <div class="rightSection">
    <h2><?php echo $playlist->getName(); ?></h2>
    <p>By <?php echo $playlist->getOwner(); ?></p>
    <p>By <?php echo $playlist->getNumberOfSongs(); ?> songs</p>
    <button class="button" onclick="deletePlaylist('<?php echo $playlistID; ?>')">DELETE PLAYLIST</button>
  </div>
</div>

<div class="trackListContainer">
  <ul class="trackList">
    <?php
      $songIDArray = $playlist->getSongIDs();
      $i = 1;
      foreach($songIDArray as $songID) {
        $playlistSong = new Song($connection, $songID);
        $songArtist = $playlistSong->getArtist();

        echo "<li class='tracklistRow'>
                <div class='trackCount'>
                  <img class='play' src='assets/images/icons/play_white.png' onclick='setTrack(\"" .  $playlistSong->getID()  . "\", temporaryPlayList, true)'>
                  <span class='trackNumber'>$i</span>
                </div>

                <div class='trackInfo'>
                  <span class='trackName'>" . $playlistSong->getTitle() . "</span>
                  <span class='artistName'>" . $songArtist->getName() . "</span>
                </div>

                <div class='trackOptions'>
                  <img class='optionButton' src='assets/images/icons/more.png'>
                </div>

                <div class='trackDuration'>
                  <span class='duration'>" . $playlistSong->getDuration() . "</span>
                </div>
              </li>";

        $i++;
      }
    ?>

    <script>
      var tempSongIDs = '<?php echo json_encode($songIDArray) ?>';
      temporaryPlayList = JSON.parse(tempSongIDs);
    </script>

  </ul>
</div>
