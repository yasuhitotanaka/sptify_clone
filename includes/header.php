<?php

  include("includes/config.php");
  include("includes/classes/Artist.php");
  include("includes/classes/Album.php");
  include("includes/classes/Song.php");
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

    <div id="mainContainer">
      <div id="topContainer">
        <?php include("includes/navBarContainer.php") ?>

        <div id="mainViewContainer">
          <div id="mainContent">
