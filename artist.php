<?php
  include("includes/includedFiles.php");

  if (isset($_GET['id'])) {
    $artistID = $_GET['id'];
  } else {
    header("Location: indx.php");
  }

  $artist = new Artist($connection, $artistID);
?>

<div class="entityInfo borderBottom">
  <div class="centerSection">
    <div class="artistInfo centerizeText">
      <h1 class="artistName"><?php echo $artist->getName() ?></h1>

      <div class="headerButtons">
        <button class="button green" onclick="playFirstSong()">PLAY</button>
      </div>
    </div>
  </div>
</div>

<div class="trackListContainer borderBottom">
  <h2 class="centerizeText">SONGS</h2>
  <ul class="trackList">
    <?php
      $songIDArray = $artist->getSongIDs();
      $i = 1;
      foreach($songIDArray as $songID) {

        if ($i > 5) {
          break;
        }

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

<div class="gridViewContainer">
  <h2 class="centerizeText">ALBUMS</h2>
  <?php
    $albumQuery = mysqli_query($connection, "SELECT * FROM albums WHERE artist='$artistID'");

    while($row = mysqli_fetch_array($albumQuery)) {

      echo "<div class='gridViewItem'>
              <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
                <img src='" . $row['artworkPath'] .  "'>
                <div class='gridViewInfo'>"
                . $row['title'] .
                "</div>
              </span>
            </div>";
    }
   ?>
</div>

<nav class="optionsMenu">
  <input type="hidden" class="songID">
  <?php echo Playlist::getPlaylistDropdown($connection, $userLoggedIn->getUserName()); ?>
</nav>
