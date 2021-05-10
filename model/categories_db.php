<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: categories_db.php


class Categories 
{
    // DB Connection
    private $conn;
    private $table = 'categories';

    // Category Properties
    public $categoryId;
    public $category;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Categories
    public function read()
    {
        // Create Query
        $query = 'SELECT id, category
                  FROM categories
                  ORDER BY id';

        // Prepare Query 
        $stmt = $this->conn->prepare($query);

        // Execute Query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Category by Category Id
    public function get_single_category()
    {
        // Create Query
        $query = 'SELECT id, category
                      FROM categories 
                      WHERE id = ?
                      LIMIT 0,1';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Bind Id
        $stmt->bindParam(1, $this->categoryId);

        // Execute Query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set Properties
        $this->id = $row['id'];
        $this->category = $row['category'];
    }

    // Create Category
    public function create()
    {
        // Create Query
        $query = 'INSERT INTO ' . $this->table . '
            SET 
                category = :category';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->category = htmlspecialchars(strip_tags($this->category));
        

        // Bind Data
        $stmt->bindParam(':category', $this->category);
        

        // Execute Query
        if($stmt->execute())
        {
            return true;
        }
        
        // Print Error if needed
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Update Category
    public function update()
    {
        // Create Query
        $query = 'UPDATE ' . $this->table . '
            SET 
                category = :category,
                id = :categoryId
            WHERE
                id = :categoryId';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

        // Bind Data
        $stmt->bindParam(':category', $this->category);
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

    // Delete Category
    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . '
            WHERE id = :categoryId';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

        // Bind Data
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

}

?>