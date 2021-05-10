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
    public $limit;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    
    /************************************************************
     * 
     * 
     *  API FUNCTIONS
     * 
     ************************************************************/
    
    // Get Quotes
    public function read()
    {
            // Create Query
            $query = 'SELECT q.quote, q.id, q.categoryId, q.authorId, 
                        c.category, a.author
                        FROM quotes q 
                        INNER JOIN categories c
                        ON q.categoryId = c.id
                        INNER JOIN authors a
                        ON q.authorId = a.id
                        ORDER BY q.id';

            // Prepare Query
            $stmt = $this->conn->prepare($query);

            // Execute Query
            $stmt->execute();

            return $stmt;       
    }

    // Get Limited Quantity of Quotes
    public function read_limit()
    {
        // Create Query
        $query = 'SELECT q.quote, q.id, q.categoryId, q.authorId, 
            c.category, a.author
            FROM quotes q 
            INNER JOIN categories c
            ON q.categoryId = c.id
            INNER JOIN authors a
            ON q.authorId = a.id
            LIMIT 0,?';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Bind Limit
        $stmt->bindValue(1, $this->limit, PDO::PARAM_INT);

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
                      ON q.categoryId = c.id
                      INNER JOIN authors a
                      ON q.authorId = a.id
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
        json_encode("Error: %s.\n", $stmt->error);
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
        json_encode("Error: %s.\n", $stmt->error);
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
        json_encode("Error: %s.\n", $stmt->error);
        return false;
    }

    // Get Quotes by Author Id
    public function get_author_quotes()
    {
        // Create Query
        $query = 'SELECT q.quote, q.id, q.categoryId, q.authorId, 
                      c.category, a.author
                      FROM quotes q 
                      INNER JOIN categories c
                      ON q.categoryId = c.id
                      INNER JOIN authors a
                      ON q.authorId = a.id
                      WHERE q.authorId = ?';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Bind Id
        $stmt->bindParam(1, $this->authorId);

        // Execute Query
        $stmt->execute();

        return $stmt;
    }

    // Get Quotes by Category Id
    public function get_category_quotes()
    {
        // Create Query
        $query = 'SELECT q.quote, q.id, q.categoryId, q.authorId, 
                      c.category, a.author
                      FROM quotes q 
                      INNER JOIN categories c
                      ON q.categoryId = c.id
                      INNER JOIN authors a
                      ON q.authorId = a.id
                      WHERE q.categoryId = ?';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Bind Id
        $stmt->bindParam(1, $this->categoryId);

        // Execute Query
        $stmt->execute();

        return $stmt;
    }

    // Get Quotes by Category Id
    public function get_quotes_by_all()
    {
        // Create Query
        $query = 'SELECT q.quote, q.id, q.categoryId, q.authorId, 
                      c.category, a.author
                      FROM quotes q 
                      INNER JOIN categories c
                      ON q.categoryId = c.id
                      INNER JOIN authors a
                      ON q.authorId = a.id
                      WHERE q.categoryId = ?
                      AND q.authorId = ?';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Bind Id
        $stmt->bindParam(1, $this->categoryId);
        $stmt->bindParam(2, $this->authorId);

        // Execute Query
        $stmt->execute();

        return $stmt;
    }


    /************************************************************
     * 
     * 
     *  USER SITE FUNCTIONS
     * 
     ************************************************************/
    


    // Adds quote to DB
    public function add_quote()
    {
        $quote_name = $this->quote;
        $author_id = $this->authorId;
        $category_id = $this->categoryId;
        $query = 'INSERT INTO quotes
                    (quote, authorId, categoryId)
                  VALUES
                    (:quote_name, :author_id, :category_id)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':quote_name', $quote_name);
        $stmt->bindValue(':author_id', $author_id);
        $stmt->bindValue(':category_id', $category_id);
        $stmt->execute();
        $stmt->closeCursor();
        return $stmt;
    }

    // Get Quotes by Author Id
    public function get_quotes_by_author($authorId)
    {
        // Create Query
        $query = 'SELECT q.quote, q.id, q.categoryId, q.authorId, 
                      c.category, a.author
                      FROM quotes q 
                      INNER JOIN categories c
                      ON q.categoryId = c.id
                      INNER JOIN authors a
                      ON q.authorId = a.id
                      WHERE id = :authorid';
        
        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Clean Data
        //$this->authorId = htmlspecialchars(strip_tags($this->authorId));

        // Bind Data
        $stmt->bindValue(':authorid', $authorId);

        // Execute Query
        $stmt->execute();

        $results = $stmt->fetchAll();

        $stmt->closeCursor();

        return $results;
    }

    // Get Quotes by Category Id
    public function get_quotes_by_category($categoryId)
    {
        // Create Query
        $query = 'SELECT q.quote, q.id, q.categoryId, q.authorId, 
                      c.category, a.author
                      FROM quotes q 
                      INNER JOIN categories c
                      ON q.categoryId = c.id
                      INNER JOIN authors a
                      ON q.authorId = a.id
                      WHERE id = :categoryId';
        
        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

        // Bind Data
        $stmt->bindParam(':categoryId', $categoryId);

        // Execute Query
        $stmt->execute();

        return $stmt;
    }

    // Get Quotes by Author Id AND Category Id
    public function get_quotes_by_both($authorId, $categoryId)
    {
        // Create Query
        $query = 'SELECT q.quote, q.id, q.categoryId, q.authorId, 
                      c.category, a.author
                      FROM quotes q 
                      INNER JOIN categories c
                      ON q.categoryId = c.id
                      INNER JOIN authors a
                      ON q.authorId = a.id
                      WHERE id = :authorId
                      AND id = :categoryId';
        
        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->authorId = htmlspecialchars(strip_tags($this->authorId));
        $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

        // Bind Data
        $stmt->bindParam(':authorId', $authorId);
        $stmt->bindParam(':categoryId', $categoryId);

        // Execute Query
        $stmt->execute();

        return $stmt;
    }
}
?>