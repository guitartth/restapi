<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: quotes_db.php

class Quotes 
{
    // DB Connection
    private $conn;
    private $table = 'quotes';

    // Quote Properties
    public $id;
    public $categoryId;
    public $authorId;
    public $quote;
    public $author;
    public $category;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Quotes
    public function read()
    {
        // Create Query
        $query = 'SELECT q.quote, q.id, q.categoryId, q.authorId, 
                      c.category, a.author
                      FROM quotes q 
                      INNER JOIN categories c
                      ON q.categoryId = c.categoryId
                      INNER JOIN authors a
                      ON q.authorId = a.authorId
                      ORDER BY q.id';
        
        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Execute Query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Quote by Quote Id
    public function get_single_quote()
    {
        // Create Query
        $query = 'SELECT q.quote, q.id, q.categoryId, q.authorId, 
                      c.category, a.author
                      FROM quotes q 
                      INNER JOIN categories c
                      ON q.categoryId = c.categoryId
                      INNER JOIN authors a
                      ON q.authorId = a.authorId
                      WHERE q.id = ?
                      LIMIT 0,1';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Bind Id
        $stmt->bindParam(1, $this->id);

        // Execute Query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set Properties
        $this->quote = $row['quote'];
        $this->id = $row['id'];
        $this->author = $row['author'];
        $this->category = $row['category'];
    }

    // Create Quote
    public function create()
    {
        // Create Query
        $query = 'INSERT INTO ' . $this->table . '
            SET 
                quote = :quote,
                authorId = :authorId,
                categoryId = :categoryId';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->authorId = htmlspecialchars(strip_tags($this->authorId));
        $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

        // Bind Data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':authorId', $this->authorId);
        $stmt->bindParam(':categoryId', $this->categoryId);

        // Execute Query
        if($stmt->execute())
        {
            return true;
        }
        
        // Print Error if needed
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Update Quote
    public function update()
    {
        // Create Query
        $query = 'UPDATE ' . $this->table . '
            SET 
                quote = :quote,
                authorId = :authorId,
                categoryId = :categoryId
            WHERE
                id = :id';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->authorId = htmlspecialchars(strip_tags($this->authorId));
        $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

        // Bind Data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':authorId', $this->authorId);
        $stmt->bindParam(':categoryId', $this->categoryId);
        $stmt->bindParam(':id', $this->id);

        // Execute Query
        if($stmt->execute())
        {
            return true;
        }
        
        // Print Error if needed
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Delete Quote
    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . '
            WHERE id = :id';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind Data
        $stmt->bindParam(':id', $this->id);

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
class Quotes 
{

    public static function get_quotes()
        {
            $db = Database::getDB();
            $query = 'SELECT q.quote, q.id, q.categoryId, q.authorId, 
                      c.category, a.author
                      FROM quotes q 
                      INNER JOIN categories c
                      ON q.categoryId = c.categoryId
                      INNER JOIN authors a
                      ON q.authorId = a.authorId
                      ORDER BY q.id';
            $statement = $db->prepare($query);
            $statement->execute();
            $quotes = $statement->fetchAll();
            $statement->closeCursor();
            return $quotes;
        }

        public static function get_quote_name($quote_id)
        {
            if(!$quote_id)
            {
                return "All Quotes";
            } 
            $db = Database::getDB();
            $query = 'SELECT * FROM quotes
                      WHERE id = :quote_id';
            $statement = $db->prepare($query);
            $statement->bindValue(':quote_id', $quote_id);
            $statement->execute();
            $quote = $statement->fetchAll();
            $statement->closeCursor();
            return $quote;
        }

        public static function add_quote($quote_name, $author_id, $category_id)
        {
            $db = Database::GetDB();
            $query = 'INSERT INTO quotes
                        (quote, authorId, categoryId)
                      VALUES
                        (:quote_name, :author_id, :category_id)';
            $statement = $db->prepare($query);
            $statement->bindValue(':quote_name', $quote_name);
            $statement->bindValue(':author_id', $author_id);
            $statement->bindValue(':category_id', $category_id);
            $statement->execute();
            $statement->closeCursor();
        }

        public static function get_quotes_by_category($category_id)
        {
            $db = Database::getDB();
            $query = 'SELECT q.id, q.quote, c.category, a.author 
                      FROM quotes q
                      LEFT JOIN authors a ON q.authorId = a.authorId
                      LEFT JOIN categories c ON q.categoryId = c.categoryId
                      WHERE q.categoryId = :category_id';
            $statement = $db->prepare($query);
            $statement->bindValue(':category_id', $category_id);
            $statement->execute();
            $quotes = $statement->fetchAll();
            $statement->closeCursor();
            return $quotes;
        }

        public static function get_quotes_by_author($author_id)
        {
            $db = Database::getDB();
            $query = 'SELECT q.id, q.quote, c.category, a.author 
                      FROM quotes q
                      LEFT JOIN authors a ON q.authorId = a.authorId
                      LEFT JOIN categories c ON q.categoryId = c.categoryId
                      WHERE q.authorId = :author_id';
            $statement = $db->prepare($query);
            $statement->bindValue(':author_id', $author_id);
            $statement->execute();
            $quotes = $statement->fetchAll();
            $statement->closeCursor();
            return $quotes;
        }

        public static function get_quotes_by_all($author_id, $category_id)
        {
            $db = Database::getDB();
            $query = 'SELECT q.id, q.quote, c.category, a.author
                      FROM quotes q
                      LEFT JOIN authors a ON q.authorId = a.authorId
                      LEFT JOIN categories c ON q.categoryId = c.categoryId
                      WHERE q.authorId = :author_id && q.categoryId = :category_id';
            $statement = $db->prepare($query);
            $statement->bindValue(':author_id', $author_id);
            $statement->bindValue(':category_id', $category_id);
            $statement->execute();
            $quotes = $statement->fetchAll();
            $statement->closeCursor();
            return $quotes;
        }
}
*/
?>