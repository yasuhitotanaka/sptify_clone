<?php
  include("includes/includedFiles.php");

  if (isset($_GET['id'])) {
    $albumID = $_GET['id'];
  } else {
    header("Location: indx.php");
  }

  $album = new Album($connection, $albumID);
  $artist = $album->getArtist();
  $artistID = $artist->getID();
 ?>

<div class="entityInfo">
  <div class="leftSection">
    <img src="<?php echo $album->getArtworkPath(); ?>" alt="album">
  </div>

  <div class="rightSection">
    <h2><?php echo $album->getTitle(); ?></h2>
    <p role="link" tabindex="0" onclick="openPage('artist.php?id=$artistID')">
      By <?php echo $artist->getName(); ?></p>
    <p>By <?php echo $album->getNumberOfSongs(); ?> songs</p>
  </div>
</div>

<div class="trackListContainer">
  <ul class="trackList">
    <?php
      $songIDArray = $album->getSongIDs();
      $i = 1;
      foreach($songIDArray as $songID) {
        $albumSong = new Song($connection, $songID);
        $albumArtist = $albumSong->getArtist();

        echo "<li class='tracklistRow'>
                <div class='trackCount'>
                  <img class='play' src='assets/images/icons/play_white.png' onclick='setTrack(\"" .  $albumSong->getID()  . "\", temporaryPlayList, true)'>
                  <span class='trackNumber'>$i</span>
                </div>

                <div class='trackInfo'>
                  <span class='trackName'>" . $albumSong->getTitle() . "</span>
                  <span class='artistName'>" . $albumArtist->getName() . "</span>
                </div>

                <div class='trackOptions'>
                  <input type='hidden' class='songID' value='" . $albumSong->getID() . "'>
                  <p></p>
                  <img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                </div>

                <div class='trackDuration'>
                  <span class='duration'>" . $albumSong->getDuration() . "</span>
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

  <nav class="optionsMenu">
    <input type="hidden" class="songID">
    <?php echo Playlist::getPlaylistDropdown($connection, $userLoggedIn->getUserName()); ?>
  </nav>
