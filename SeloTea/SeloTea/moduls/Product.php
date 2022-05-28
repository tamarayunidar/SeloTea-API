<?php 
  class Post {
    // DB stuff
    private $conn;
    private $table = 'Product';

    // Post Properties
    public $id;
    public $name;
    public $stock;
    public $price;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table . ' ORDER BY Id';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Post
    public function read_single() {
          // Create query
          $query = 'SELECT * FROM ' . $this->table . ' WHERE Id = ?';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->id = $row['id'];
          $this->name = $row['name'];
          $this->stock = $row['stock'];
          $this->price = $row['price'];
    }

        // Create Post
        public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET id = :id, name = :name, stock = :stock, price = :price';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->stock = htmlspecialchars(strip_tags($this->stock));
          $this->price = htmlspecialchars(strip_tags($this->price));

          // Bind data
          $stmt->bindParam(':id', $this->id);
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':stock', $this->stock);
          $stmt->bindParam(':price', $this->price);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
  }
