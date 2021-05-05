<?php


    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require('../../model/database.php');
    require('../../model/categories_db.php');

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category Object
    $category = new Categories($db);
    // Category Query
    $result = $category->read();
    // Get Row Count
    $count = $result->rowCount();
    
    // Check if any Categories
    if($count > 0)
    {
        // Category Array
        $cat_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            $cat_item = array(
                'categoryId' => $categoryId,
                'category' => $category
            );

            // Push to array
            array_push($cat_arr, $cat_item);
        }

        // Turn to JSON
        echo json_encode($cat_arr);
    }
    else
    {
        // No Categories
        echo json_encode(
            array('message' => 'No Categories Found')
        );
    }

