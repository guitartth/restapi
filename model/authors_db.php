<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: authors_db.php


class Authors
{

        public static function get_authors()
        {
            $db = Database::getDB();
            $query = 'SELECT * FROM authors ORDER BY author_id';
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
                      WHERE author_id = :author_id';
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
                        (Author)
                      VALUES
                        (:author_name)';
            $statement = $db->prepare($query);
            $statement->bindValue(':author_name', $author_name);
            $statement->execute();
            $statement->closeCursor();
        }

}

?>