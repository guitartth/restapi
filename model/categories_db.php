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