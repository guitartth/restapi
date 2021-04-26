<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: quotes_db.php


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
                      ON q.authorId = a.authorId';
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
            $query = '';
            $statement = $db->prepare($query);
            $statement->bindValue(':author_id', $author_id);
            $statement->bindValue(':category_id', $category_id);
            $statement->execute();
            $quotes = $statement->fetchAll();
            $statement->closeCursor();
            return $quotes;
        }
}

?>