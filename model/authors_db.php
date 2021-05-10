<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: authors_db.php

class Authors 
{
    // DB Connection
    private $conn;
    private $table = 'authors';

    // Author Properties
    public $authorId;
    public $author;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Authors
    public function read()
    {
        // Create Query
        $query = 'SELECT id, author
                  FROM authors
                  ORDER BY id';
        
        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Execute Query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Author by Author Id
    public function get_single_author()
    {
        // Create Query
        $query = 'SELECT id, author
                      FROM authors 
                      WHERE id = ?
                      LIMIT 0,1';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Bind Id
        $stmt->bindParam(1, $this->authorId);

        // Execute Query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set Properties
        $this->authorId = $row['id'];
        $this->author = $row['author'];
    }

    // Create Author
    public function create()
    {
        // Create Query
        $query = 'INSERT INTO ' . $this->table . '
            SET 
                author = :author';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->author = htmlspecialchars(strip_tags($this->author));

        // Bind Data
        $stmt->bindParam(':author', $this->author);

        // Execute Query
        if($stmt->execute())
        {
            return true;
        }
        
        // Print Error if needed
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Update Author
    public function update()
    {
        // Create Query
        $query = 'UPDATE ' . $this->table . '
            SET 
                author = :author,
                id = :authorId
            WHERE
                id = :authorId';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->authorId = htmlspecialchars(strip_tags($this->authorId));

        // Bind Data
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':authorId', $this->authorId);

        // Execute Query
        if($stmt->execute())
        {
            return true;
        }
        
        // Print Error if needed
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Delete Author
    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . '
            WHERE id = :authorId';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->authorId = htmlspecialchars(strip_tags($this->authorId));

        // Bind Data
        $stmt->bindParam(':authorId', $this->authorId);

        // Execute Query
        if($stmt->execute())
        {
            return true;
        }
        
        // Print Error if needed
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

}

?>