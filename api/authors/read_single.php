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

    // Get ID
    $author->authorId = filter_input(INPUT_GET, 'authorId', FILTER_VALIDATE_INT);

    // Get Author
    $author->get_single_author();

    // Create Array
    $author_arr = array(
        'authorId' => $author->authorId,
        'author' => $author->author,
    );

    // Turn to JSON
    print_r(json_encode($author_arr));