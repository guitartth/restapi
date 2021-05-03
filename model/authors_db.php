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
        $query = 'SELECT authorId, author
                  FROM authors
                  ORDER BY authorId';
        
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
        $query = 'SELECT authorId, author
                      FROM authors 
                      WHERE authorId = ?
                      LIMIT 0,1';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Bind Id
        $stmt->bindParam(1, $this->authorId);

        // Execute Query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set Properties
        $this->id = $row['authorId'];
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
                authorId = :authorId
            WHERE
                authorId = :authorId';

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
            WHERE authorId = :authorId';

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


// Original Working Code
/*
class Authors
{

        public static function get_authors()
        {
            $db = Database::getDB();
            $query = 'SELECT * FROM authors ORDER BY authorId';
            $statement = $db->prepare($query);
            $statement->execute();
            $authors = $statement->fetchAll();
            $statement->closeCursor();
            return $authors;
        }

        public static function get_author_name($author_id)
        {
            if(!$author_id)
            {
                return "All Authors";
            } 
            $db = Database::getDB();
            $query = 'SELECT * FROM authors
                      WHERE authorId = :author_id';
            $statement = $db->prepare($query);
            $statement->bindValue(':author_id', $author_id);
            $statement->execute();
            $author = $statement->fetchAll();
            $statement->closeCursor();
            return $author;
        }

        public static function add_author($author_name)
        {
            $db = Database::GetDB();
            $query = 'INSERT INTO authors
                        (author)
                      VALUES
                        (:author_name)';
            $statement = $db->prepare($query);
            $statement->bindValue(':author_name', $author_name);
            $statement->execute();
            $statement->closeCursor();
        }

}
*/
?>