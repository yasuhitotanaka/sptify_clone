<?php

  include("includes/config.php");

  // session_destroy(); Log out

  if (isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = $_SESSION['userLoggedIn'];
  } else {
    header("Location: register.php");
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Welcome to Spotify!!</title>
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <div id="nowPlayingBarcontainer">
      <div id="nowPlayingBar">

        <div id="nowPlayingLeft">
          <div class="content">
            <span class="albumLink">
              <img src="http://salemdigest.com/wp-content/uploads/2016/08/TITS_logo.png" alt="" class="albumArtwork">
            </span>

            <div class="trackInfo">
              <span class="trackName">
                <span>happy birthday</span>
              </span>

              <span class="artistName">
                <span>yasu tana</span>
              </span>

            </div>
          </div>
        </div>

        <div id="nowPlayingCenter">
          <div class="content playerControls">

            <div class="buttons">
              <button class="controlButton shuffle" title="shuffle button">
                <img src="assets\images\icons\shuffle.svg" alt="shuffle">
              </button>
              <button class="controlButton previous" title="previous button">
                <img src="assets\images\icons\previous.svg" alt="previous">
              </button>
              <button class="controlButton play" title="play button">
                <img src="assets\images\icons\play.svg" alt="play">
              </button>
              <button class="controlButton pause" title="pause button">
                <img src="assets\images\icons\pause.svg" alt="pause">
              </button>
              <button class="controlButton next" title="next button">
                <img src="assets\images\icons\next.svg" alt="next">
              </button>
              <button class="controlButton repeat" title="repeat button">
                <img src="assets\images\icons\repeat.svg" alt="repeat">
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

            <button class="controlButton volume" title="volume button">
              <img src="assets\images\icons\volume.svg" alt="volume">
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
  </body>
</html>
