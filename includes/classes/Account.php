<?php
  class Account {
    private $connection;
    private $errorArray;

    public function __construct($connection) {
      $this->connection = $connection;
      $this->errorArray = array();
    }

    public function register($username, $firstname, $lastname,
        $email1, $email2, $password, $password2) {
      $this->validateUsername($username);
      $this->validateFirstname($firstname);
      $this->validateLastname($lastname);
      $this->validateEmails($email1, $email2);
      $this->validatePasswords($password, $password2);

      if(empty($this->errorArray) == true) {
        return $this->insertUserDetails($username, $firstname, $lastname, $email1, $password);
      } else {
        return false;
      }
    }

    public function getError($error) {
      if(!in_array($error, $this->errorArray)) {
        $error = "";
      }
      return "<span class='errorMessage'>$error</span>";
    }

    public function login($username, $password) {
      $encryptedPassword = md5($password);
      $query = mysqli_query($this->connection,
                  "SELECT id FROM users WHERE username='$username' AND password='$encryptedPassword'");

      if (mysqli_num_rows($query) == 1) {
        return true;
      } else {
        array_push($this->errorArray, Constants::$loginFalied);
        return false;
      }
    }

    private function insertUserDetails($username, $firstname, $lastname, $email1, $password) {
      $encryptedPassword = md5($password);
      $profilePic = "assets/images/profile-pics/head_emerald.png";
      $date = date("Y-m-d");

      // to check query
      // echo "INSERT INTO users VALUES ('', '$username', '$firstname', '$lastname', '$email1', '$encryptedPassword', '$date', '$profilePic') "
      $result = mysqli_query($this->connection,
       "INSERT INTO users VALUES ('', '$username', '$firstname', '$lastname', '$email1', '$encryptedPassword', '$date', '$profilePic') ");

       return $result;
    }

    private function validateUsername($username) {
      if (strlen($username) > 25 || strlen($username) < 5) {
        array_push($this->errorArray, Constants::$userNameNotAlphanumeric);
        return;
      }
      $checkUsernameQuery = mysqli_query($this->connection, "SELECT username FROM users WHERE username='$username'");
      if(mysqli_num_rows($checkUsernameQuery) != 0) {
        array_push($this->errorArray, Constants::$usernameTaken);
        return;
      }
    }

    private function validateFirstname($firstname) {
      if (strlen($firstname) > 25 || strlen($firstname) < 2) {
        array_push($this->errorArray, Constants::$firstNameNotAlphanumeric);
        return;
      }
    }

    private function validateLastname($lastname) {
      if (strlen($lastname) > 25 || strlen($lastname) < 2) {
        array_push($this->errorArray, Constants::$lastNameNotAlphanumeric);
        return;
      }
    }

    private function validateEmails($email1, $email2) {
      if ($email1 != $email2) {
        array_push($this->errorArray, Constants::$emailsDoNoMatch);
        return;
      }
      if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
        array_push($this->errorArray, Constants::$emailInvalid);
        return;
      }
      $checkEmailQuery = mysqli_query($this->connection, "SELECT email FROM users WHERE email='$email1'");
      if(mysqli_num_rows($checkEmailQuery) != 0) {
        array_push($this->errorArray, Constants::$emailTaken);
        return;
      }
    }

    private function validatePasswords($password, $password2) {
      if ($password != $password2) {
        array_push($this->errorArray, Constants::$passwordsDoNoMatch);
        return;
      }
      if(preg_match('/^A-Za-z0-9/',$password)) {
        array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
        return;
      }
      if (strlen($password) > 30 || strlen($password) < 5) {
        array_push($this->errorArray, Constants::$passwordCharacters);
        return;
      }
    }
}
?>
