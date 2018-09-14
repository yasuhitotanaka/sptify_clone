<?php
  include("includes/includedFiles.php");

  if (isset($_GET['term'])) {
    $term = urldecode($_GET['term']);
  } else {
    $term = "";
  }
?>

<div class="searchContainer">

  <h4>Search for an artist, album or song</h4>
  <input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="Start typing ..." onfocus="this.value = this.value">
</div>

<script>

  $(".searchInput").focus();

  $(function(){

    $(".searchInput").keyup(function() {
      clearTimeout(timer);

      timer = setTimeout(function() {
        var val = $(".searchInput").val();
        openPage("search.php?term=" + val);
      }, 2000);
    })
  })
</script>

<?php if($term == "") exit(); ?>

<div class="trackListContainer borderBottom">
  <h2 class="centerizeText">SONGS</h2>
  <ul class="trackList">
    <?php

      $songsQuery = mysqli_query($connection, "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");

      if(mysqli_num_rows($songsQuery) == 0) {
        echo "<span class='noResults'>No songs found matching " . $term . "</span>";
      }

      $songIDArray = array();
      $i = 1;
      while($row = mysqli_fetch_array($songsQuery)) {

        if ($i > 15) {
          break;
        }

        array_push($songIDArray, $row['id']);

        $albumSong = new Song($connection, $row['id']);
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

<div class="artistContainer borderBottom">
  <h2 class="centerizeText">ARTISTS</h2>

  <?php
  $artistsQuery = mysqli_query($connection, "SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10");

  if(mysqli_num_rows($artistsQuery) == 0) {
    echo "<span class='noResults'>No artists found matching " . $term . "</span>";
  }

  while($row = mysqli_fetch_array($artistsQuery)) {
    $artistFound = new Artist($connection, $row['id']);

    echo "<div class='searchResultRow'>
            <span class='artistName'>
              <span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistFound->getID() . "\")'>
              "
              . $artistFound-> getName() .
              "
              </span>
            </span>
          </div>";
  }
  ?>
</div>

<div class="gridViewContainer">
  <h2 class="centerizeText">ALBUMS</h2>
  <?php
    $albumQuery = mysqli_query($connection, "SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 10");

    if(mysqli_num_rows($albumQuery) == 0) {
      echo "<span class='noResults'>No albums found matching " . $term . "</span>";
    }

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
