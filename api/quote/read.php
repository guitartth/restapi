<?php


    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require('../../model/database.php');
    require('../../model/quotes_db.php');

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quote = new Quotes($db);
    // Quote Query
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

