<?php


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
    

    // Quote Query
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
            $quote_arr['data'] = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $quote_item = array(
                    'id' => $id,
                    'quote' => $quote,
                    'author' => $author,
                    'category' => $category,
                );

                // Push to "data"
                array_push($quote_arr['data'], $quote_item);
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
            $quote_arr['data'] = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $quote_item = array(
                    'id' => $id,
                    'quote' => $quote,
                    'author' => $author,
                    'category' => $category,
                );

                // Push to "data"
                array_push($quote_arr['data'], $quote_item);
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
            $quote_arr['data'] = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $quote_item = array(
                    'id' => $id,
                    'quote' => $quote,
                    'author' => $author,
                    'category' => $category,
                );

                // Push to "data"
                array_push($quote_arr['data'], $quote_item);
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
    else
    {
        // call function to return all quotes
        $result = $quote->read();

        // Get Row Count
        $count = $result->rowCount();
    
        // Check if any Quotes
        if($count > 0)
        {
            // Quote Array
            $quote_arr = array();
            $quote_arr['data'] = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $quote_item = array(
                    'id' => $id,
                    'quote' => $quote,
                    'author' => $author,
                    'category' => $category,
                );

                // Push to "data"
                array_push($quote_arr['data'], $quote_item);
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
    
    

