<?php


    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require('../../model/database.php');
    require('../../model/authors_db.php');

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author Object
    $author = new Authors($db);
    // Author Query
    $result = $author->read();
    // Get Row Count
    $count = $result->rowCount();
    
    // Check if any Authors
    if($count > 0)
    {
        // Author Array
        $author_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            $author_item = array(
                'authorId' => $authorId,
                'author' => $author
            );

            // Push to array
            array_push($author_arr, $author_item);
        }

        // Turn to JSON
        echo json_encode($author_arr);
    }
    else
    {
        // No Authors
        echo json_encode(
            array('message' => 'No Authors Found')
        );
    }

