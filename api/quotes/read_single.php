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

    // Get ID
    $quote->id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    // Get Quote
    $quote->get_single_quote();

    // Create Array
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author' => $quote->author,
        'category' => $quote->category
    );

    // Turn to JSON
    print_r(json_encode($quote_arr));