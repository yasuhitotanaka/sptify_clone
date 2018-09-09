<?php

  include("includes/config.php");

  session_destroy();

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
  </head>
  <body>
    Hello!!
  </body>
</html>
