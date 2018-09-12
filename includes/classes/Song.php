<?php
  class Song {
    private $connection;
    private $id;
    private $mysqlData;
    private $title;
    private $artistID;
    private $albumID;
    private $duration;
    private $path;

    public function __construct($connection, $id) {
      $this->connection = $connection;
      $this->id = $id;

      $query = mysqli_query($this->connection, "SELECT * FROM songs WHERE id='$this->id'");
      $this->mysqlData = mysqli_fetch_array($query);

      $this->title = $this->mysqlData['title'];
      $this->artistID = $this->mysqlData['artist'];
      $this->albumID = $this->mysqlData['album'];
      $this->duration = $this->mysqlData['duration'];
      $this->path = $this->mysqlData['path'];
    }

    public function getID() {
      return $this->id;
    }

    public function getTitle() {
      return $this->title;
    }

    public function getArtist() {
      return new Artist($this->connection, $this->artistID);
    }

    public function getAlbum() {
      return new Album($this->connection, $this->albumID);
    }

    public function getDuration() {
      return $this->duration;
    }

    public function getPath() {
      return $this->path;
    }

  }
?>
