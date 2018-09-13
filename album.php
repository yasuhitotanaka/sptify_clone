<?php
  include("includes/includedFiles.php");

  if (isset($_GET['id'])) {
    $albumID = $_GET['id'];
  } else {
    header("Location: indx.php");
  }

  $album = new Album($connection, $albumID);
  $artist = $album->getArtist();
 ?>

<div class="entityInfo">
  <div class="leftSection">
    <img src="<?php echo $album->getArtworkPath(); ?>" alt="">
  </div>

  <div class="rightSection">
    <h2><?php echo $album->getTitle(); ?></h2>
    <p>By <?php echo $artist->getName(); ?></p>
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
                  <img class='optionButton' src='assets/images/icons/more.png'>
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
