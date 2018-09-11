<?php
  class Album {
    private $connection;
    private $id;
    private $title;
    private $artistID;
    private $genre;
    private $artworkPath;
    private $songsQuery;

    public function __construct($connection, $id) {
      $this->connection = $connection;
      $this->id = $id;

      $artistQuery = mysqli_query($this->connection, "SELECT title, artist, genre, artworkPath FROM albums WHERE id='$this->id'");
      $artist = mysqli_fetch_array($artistQuery);

      $this->title = $artist['title'];
      $this->artistID = $artist['artist'];
      $this->genre = $artist['genre'];
      $this->artworkPath = $artist['artworkPath'];

      $this->songsQuery = mysqli_query($this->connection, "SELECT id FROM songs WHERE album='$this->id' ORDER BY albumOrder ASC");
    }

    public function getTitle() {
      return $this->title;
    }

    public function getArtist() {
      return new Artist($this->connection, $this->artistID);
    }

    public function getGenre() {
      return $this->genre;
    }

    public function getArtworkPath() {
      return $this->artworkPath;
    }

    public function getNumberOfSongs() {
      $songCount = mysqli_num_rows($this->songsQuery);
      return $songCount;
    }

    public function getSongIDs() {
      $songs = array();

      while($row = mysqli_fetch_array($this->songsQuery)) {
        array_push($songs, $row['id']);
      }
      return $songs;
    }

  }
?>
