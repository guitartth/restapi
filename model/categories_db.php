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
        $query = 'SELECT categoryId, category
                  FROM categories
                  ORDER BY categoryId';

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
        $query = 'SELECT categoryId, category
                      FROM categories 
                      WHERE categoryId = ?
                      LIMIT 0,1';

        // Prepare Query
        $stmt = $this->conn->prepare($query);

        // Bind Id
        $stmt->bindParam(1, $this->categoryId);

        // Execute Query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set Properties
        $this->id = $row['categoryId'];
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
                categoryId = :categoryId
            WHERE
                categoryId = :categoryId';

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
            WHERE categoryId = :categoryId';

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

    public static function get_categories()
        {
            $db = Database::getDB();
            $query = 'SELECT * FROM categories ORDER BY categoryId';
            $statement = $db->prepare($query);
            $statement->execute();
            $categories = $statement->fetchAll();
            $statement->closeCursor();
            return $categories;
        }
}

// Original Working Code
/*
class Categories
{

    public static function get_categories()
        {
            $db = Database::getDB();
            $query = 'SELECT * FROM categories ORDER BY categoryId';
            $statement = $db->prepare($query);
            $statement->execute();
            $categories = $statement->fetchAll();
            $statement->closeCursor();
            return $categories;
        }

        public static function get_category_name($category_id)
        {
            if(!$category_id)
            {
                return "All Categories";
            } 
            $db = Database::getDB();
            $query = 'SELECT * FROM categories
                      WHERE categoryId = :category_id';
            $statement = $db->prepare($query);
            $statement->bindValue(':category_id', $category_id);
            $statement->execute();
            $category = $statement->fetchAll();
            $statement->closeCursor();
            return $category;
        }

        public static function add_cateogry($category_name)
        {
            $db = Database::GetDB();
            $query = 'INSERT INTO categories
                        (category)
                      VALUES
                        (:category_name)';
            $statement = $db->prepare($query);
            $statement->bindValue(':category_name', $category_name);
            $statement->execute();
            $statement->closeCursor();
        }
}
*/
?>