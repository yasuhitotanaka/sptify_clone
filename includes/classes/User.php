<?php
  class User {
    private $connection;
    private $username;

    public function __construct($connection, $username) {
      $this->connection = $connection;
      $this->username = $username;
    }

    public function getUserName() {
      return $this->username;
    }

  }
?>
