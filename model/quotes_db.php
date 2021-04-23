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
                        (Quotes)
                      VALUES
                        (:quote)';
            $statement = $db->prepare($query);
            $statement->bindValue(':quote', $quote_name);
            $statement->execute();
            $statement->closeCursor();
        }

        public static function get_quotes_by_category($category_id)
        {

            return $quotes;
        }

        public static function get_quotes_by_author($author_id)
        {
            
            return $quotes;
        }
}

?>