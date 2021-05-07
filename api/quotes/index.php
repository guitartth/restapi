<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: quotes/index.php


    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require('../../model/database.php');
    require('../../model/quotes_db.php');
    require('../../model/authors_db.php');
    require('../../model/categories_db.php');

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quote = new Quotes($db);

    // Get authorId
    $authorId = filter_input(INPUT_GET, 'authorId', FILTER_VALIDATE_INT);
    
    // Get categoryId
    $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);

    // Get Limit
    $limit = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT);
    

    // API Request Supplies Both Category and Author Id's
    if($authorId && $categoryId)
    {
        $quote->authorId = $authorId;
        $quote->categoryId = $categoryId;

        // call function for both params
        $result = $quote->get_quotes_by_all();

        // Get Row Count
        $count = $result->rowCount();

        // Check if any Quotes
        if($count > 0)
        {
            // Quote Array
            $quote_arr = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $quote_item = array(
                    'id' => $id,
                    'quote' => $quote,
                    'author' => $author,
                    'category' => $category,
                );

                // Push to array
                array_push($quote_arr, $quote_item);
            }

            // Turn to JSON
            echo json_encode($quote_arr);
        }
        else
        {
            // No Quotes
            echo json_encode(
                array('message' => 'No Quotes Found')
            );
        }
    }
    // API Request Supplies Author Id
    else if($authorId)
    {
        $quote->authorId = $authorId;

        // call function for specific author
        $result = $quote->get_author_quotes();

        // Get Row Count
        $count = $result->rowCount();

        // Check if any Quotes
        if($count > 0)
        {
            // Quote Array
            $quote_arr = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $quote_item = array(
                    'id' => $id,
                    'quote' => $quote,
                    'author' => $author,
                    'category' => $category,
                );

                // Push to array
                array_push($quote_arr, $quote_item);
            }

            // Turn to JSON
            echo json_encode($quote_arr);
        }
        else
        {
            // No Quotes
            echo json_encode(
                array('message' => 'No Quotes Found')
            );
        }
    }
    // API Request Supplies Category Id
    else if($categoryId)
    {
        $quote->categoryId = $categoryId;

        // call function for specific category
        $result = $quote->get_category_quotes();

        // Get Row Count
        $count = $result->rowCount();

        // Check if any Quotes
        if($count > 0)
        {
            // Quote Array
            $quote_arr = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $quote_item = array(
                    'id' => $id,
                    'quote' => $quote,
                    'author' => $author,
                    'category' => $category,
                );

                // Push to array
                array_push($quote_arr, $quote_item);
            }

            // Turn to JSON
            echo json_encode($quote_arr);
        }
        else
        {
            // No Quotes
            echo json_encode(
                array('message' => 'No Quotes Found')
            );
        }
    }
    // API Request with No Author or Category Restrictions
    else 
    {   
        // API Request with Limited Quotes Returned
        if($limit)
        {   
            $quote->limit = $limit;

            // call function to return all quotes
            $result = $quote->read_limit();

            // Get Row Count
            $count = $result->rowCount();

            // Check if any Quotes
            if ($count > 0) 
            {

                // Quote Array
                $quote_arr = array();
            
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
                {
                    extract($row);
                    $quote_item = array(
                        'id' => $id,
                        'quote' => $quote,
                        'author' => $author,
                        'category' => $category,
                );

                // Push to array
                array_push($quote_arr, $quote_item);
                }

            // Turn to JSON
            echo json_encode($quote_arr);
            } 
            else 
            {
                // No Quotes
                echo json_encode(
                    array('message' => 'No Quotes Found')
                );
            }   
        }
        // API Request Returns All Quotes
        else
        {
            // call function to return all quotes
            $result = $quote->read();

            // Get Row Count
            $count = $result->rowCount();

            // Check if any Quotes
            if ($count > 0) {
                // Quote Array
                $quote_arr = array();

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $quote_item = array(
                        'id' => $id,
                        'quote' => $quote,
                        'author' => $author,
                        'category' => $category,
                    );

                    // Push to array
                    array_push($quote_arr, $quote_item);
                }

                // Turn to JSON
                echo json_encode($quote_arr);
            } 
            else 
            {
                // No Quotes
                echo json_encode(
                    array('message' => 'No Quotes Found')
                );
            }   
        } 
    }
    
    

