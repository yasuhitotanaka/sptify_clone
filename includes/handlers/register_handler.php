<?php

function sanitizeFormPassword($inputText) {
  $inputText = strip_tags($inputText);
  return $inputText;
}

function sanitizeFormUsername($inputText) {
  $inputText = strip_tags($inputText);
  $inputText = str_replace(" ", "", $inputText);
  return $inputText;
}

function sanitizeFormString($inputText) {
  $inputText = strip_tags($inputText);
  $inputText = str_replace(" ", "", $inputText);
  $inputText = ucfirst(strtolower($inputText));
  return $inputText;
}

if(isset($_POST['loginButton'])) {
  // Login button was pressed!
}

if(isset($_POST['registerButton'])) {

  $username = sanitizeFormUsername($_POST['username']);
  $firstname = sanitizeFormString($_POST['firstName']);
  $lastname = sanitizeFormString($_POST['lastName']);
  $email1 = sanitizeFormString($_POST['email1']);
  $email2 = sanitizeFormString($_POST['email2']);
  $password = sanitizeFormPassword($_POST['password']);
  $password2 = sanitizeFormPassword($_POST['password2']);

  $wasSuccessful = $account->register($username, $firstname, $lastname,
                                      $email1, $email2, $password, $password2);

  if ($wasSuccessful == true) {
    $_SESSION['userLoggedIn'] = $username;
    header("Location: index.php");
  }
}

?>
