<?php

  $songQuery = mysqli_query($connection, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
  $resultArray = array();

  while($row = mysqli_fetch_array($songQuery)) {
    array_push($resultArray, $row['id']);
  }

  $jsonArray = json_encode($resultArray);
?>

<script>
  $(document).ready(function() {
    var newPlayList = <?php echo $jsonArray; ?>;
    audioElement = new Audio();
    setTrack(newPlayList[0], newPlayList, false);

    $("#nowPlayingBarcontainer").on("mousedown touchstart mousemove touchmove",
      function(e) {
        e.preventDefault();
      });

    $(".playbackBar .progressBar").mousedown(function() {
      mouseDown = true;
    });
    $(".playbackBar .progressBar").mousemove(function(e) {
      if(mouseDown = true) {
        // Set time of song, depending on position of mouse
        timeFromOffset(e, this);
      }
    });
    $(".playbackBar .progressBar").mouseup(function(e) {
      timeFromOffset(e, this);
    });

    $(".volumeBar .progressBar").mousedown(function() {
      mouseDown = true;
    });
    $(".volumeBar .progressBar").mousemove(function(e) {
      if(mouseDown = true) {
        var percentage = e.offsetX / $(this).width();
        if (0 <= percentage && percentage <= 1) {
          audioElement.audio.volume = percentage;
        }
      }
    });
    $(".volumeBar .progressBar").mouseup(function(e) {
      var percentage = e.offsetX / $(this).width();
      if (0 <= percentage && percentage <= 1) {
        audioElement.audio.volume = percentage;
      }
    });

    $(document).mouseup(function() {
      mouseDown = false;
    });

  });


  function timeFromOffset(mouse, progressBar) {
    var percentage = mouse.offsetX / $(progressBar).width() * 100; // this => ".playbackBar .progressBar"
    var seconds = audioElement.audio.duration * (percentage / 100);
    audioElement.setTime(seconds);
  }

  function previousSong() {
    if(audioElement.audio.currrentTime >= 3 || currentIndex == 0) {
      audioElement.setTime(0);
    } else {
      currentIndex--;
      setTrack(currentlyPlayList[currentIndex], currentlyPlayList, true);
    }
  }

  function nextSong() {
    if (repeat == true) {
      audioElement.setTime(0);
      playSong();
      return;
    }
    if(currentIndex == currentlyPlayList.length - 1) {
      currentIndex = 0;
    } else {
      currentIndex++;
    }
    var trackToPlay = shuffle ? shufflePlayList[currentIndex] : currentlyPlayList[currentIndex];
    setTrack(trackToPlay, currentlyPlayList, true);
  }

  function setRepeat() {
    repeat = !repeat;
    var imageName = repeat ? "repeat_active.png" : "repeat.png";
    $(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
  }

  function setMute() {
    audioElement.audio.muted = !audioElement.audio.muted;
    var imageName = audioElement.audio.muted ? "volume_mute.png" : "volume.png";
    $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
  }

  function setShuffle() {
    shuffle = !shuffle;
    var imageName = shuffle ? "shuffle_active.png" : "shuffle.png";
    $(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

    if (shuffle == true) {
      // Shuffle shufflePlayList again here
      shuffleArray(shufflePlayList);
      currentIndex = shufflePlayList.indexOf(audioElement.currentlyPlaying.id);
    } else {
      // go back to the un-shuffled playlist
      currentIndex = currentlyPlayList.indexOf(audioElement.currentlyPlaying.id);
    }
  }

  function shuffleArray(a) {
      for (let i = a.length - 1; i > 0; i--) {
          const j = Math.floor(Math.random() * (i + 1));
          [a[i], a[j]] = [a[j], a[i]];
      }
      return a;
  }

  function setTrack(trackID, newPlayList, is_play) {

    if (newPlayList != currentlyPlayList) {
      currentlyPlayList = newPlayList;
      shufflePlayList = currentlyPlayList.slice();
      shuffleArray(shufflePlayList);
    }

    if (shuffle == true) {
      currentIndex = shufflePlayList.indexOf(trackID);
    } else {
      currentIndex = currentlyPlayList.indexOf(trackID);
    }
    pauseSong();

    $.post("includes/handlers/ajax/getSongJson.php",
      { songID: trackID }, function(data){
      var track = JSON.parse(data);
      $(".trackName span").text(track.title);

      $.post("includes/handlers/ajax/getArtistJson.php",
       { artistID: track.artist }, function(data){
        var artist = JSON.parse(data);
        $(".artistName span").text(artist.name);
        $(".artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
      });

      $.post("includes/handlers/ajax/getAlbumJson.php",
        { albumID: track.album }, function(data){
        var album = JSON.parse(data);
        $(".albumLink img").attr("src", album.artworkPath);
        $(".albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
        $(".trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
      });

      audioElement.setTrack(track);
      if(is_play) {
        playSong();
      }
    });
  }

  function playSong(){
    if(audioElement.audio.currentTime == 0) {
      $.post("includes/handlers/ajax/updatePlays.php",
        { songID: audioElement.currentlyPlaying.id });
    }

    $(".controlButton.play").hide();
    $(".controlButton.pause").show();
    audioElement.play();
  }

  function pauseSong(){
    $(".controlButton.pause").hide();
    $(".controlButton.play").show();
    audioElement.pause();
  }
</script>

<div id="nowPlayingBarcontainer">
  <div id="nowPlayingBar">

    <div id="nowPlayingLeft">
      <div class="content">
        <span class="albumLink">
          <img role="link" tabindex="0" src="" alt="" class="albumArtwork">
        </span>
        <div class="trackInfo">
          <span class="trackName">
            <span role="link" tabindex="0"></span>
          </span>
          <span class="artistName">
            <span role="link" tabindex="0"></span>
          </span>
        </div>
      </div>
    </div>

    <div id="nowPlayingCenter">
      <div class="content playerControls">

        <div class="buttons">
          <button class="controlButton shuffle" title="shuffle button" onclick="setShuffle()">
            <img src="assets\images\icons\shuffle.png" alt="shuffle">
          </button>
          <button class="controlButton previous" title="previous button" onclick="previousSong()">
            <img src="assets\images\icons\previous.png" alt="previous">
          </button>
          <button class="controlButton play" title="play button" onclick="playSong()">
            <img src="assets\images\icons\play.png" alt="play">
          </button>
          <button class="controlButton pause" title="pause button" onclick="pauseSong()">
            <img src="assets\images\icons\pause.png" alt="pause">
          </button>
          <button class="controlButton next" title="next button" onclick="nextSong()">
            <img src="assets\images\icons\next.png" alt="next">
          </button>
          <button class="controlButton repeat" title="repeat button" onclick="setRepeat()">
            <img src="assets\images\icons\repeat.png" alt="repeat">
          </button>
        </div>

        <div class="playbackBar">
          <span class="progressTime currrent">0.00</span>
          <div class="progressBar">
            <div class="progressBarBg">
              <div class="progress"></div>
            </div>
          </div>
          <span class="progressTime remaining">0.00</span>
        </div>
      </div>
    </div>

    <div id="nowPlayingRight">
      <div class="volumeBar">
        <button class="controlButton volume" title="volume button" onclick="setMute()">
          <img src="assets\images\icons\volume.png" alt="volume">
        </button>
        <div class="progressBar">
          <div class="progressBarBg">
            <div class="progress"></div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
