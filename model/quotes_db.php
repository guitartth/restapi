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
            $query = 'SELECT * FROM quotes ORDER BY quote_id';
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
                      WHERE quote_id = :quote_id';
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
                        (quote, author_id, category_id)
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
            $query = 'SELECT q.quote_id, q.quote, c.category, a.author 
                      FROM quotes q
                      LEFT JOIN authors a ON q.author_id = a.author_id
                      LEFT JOIN categories c ON q.category_id = c.category_id
                      WHERE q.category_id = :category_id';
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
            $query = 'SELECT q.quote_id, q.quote, c.category, a.author 
                      FROM quotes q
                      LEFT JOIN authors a ON q.author_id = a.author_id
                      LEFT JOIN categories c ON q.category_id = c.category_id
                      WHERE q.author_id = :author_id';
            $statement = $db->prepare($query);
            $statement->bindValue(':author_id', $author_id);
            $statement->execute();
            $quotes = $statement->fetchAll();
            $statement->closeCursor();
            return $quotes;
        }
}

?>