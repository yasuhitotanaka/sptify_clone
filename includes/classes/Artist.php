<?php
  class Artist {
    private $connection;
    private $id;
    private $name;

    public function __construct($connection, $id) {
      $this->connection = $connection;
      $this->id = $id;
    }

    public function getID() {
      return $this->id;
    }

    public function getName() {
      $artistQuery = mysqli_query($this->connection, "SELECT name FROM artists WHERE id='$this->id'");
      $artist = mysqli_fetch_array($artistQuery);
      return $artist['name'];
    }

    public function getSongIDs() {
      $songs = array();
      $songsQuery = mysqli_query($this->connection, "SELECT id FROM songs WHERE artist='$this->id' ORDER BY albumOrder ASC");
      while($row = mysqli_fetch_array($songsQuery)) {
        array_push($songs, $row['id']);
      }
      return $songs;
    }
  }
?>
