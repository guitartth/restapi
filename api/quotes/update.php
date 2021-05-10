<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: quotes/update.php


    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    require('../../model/database.php');
    require('../../model/quotes_db.php');

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quote = new Quotes($db);

    // Get Raw Posted Data
    $data = json_decode(file_get_contents("php://input"));

    // Set Id to Update
    $quote->id = $data->id;

    $quote->quote = $data->quote;
    $quote->authorId = $data->id;
    $quote->categoryId = $data->id;

    // Update Quote
    if($quote->update())
    {
        echo json_encode(
            array('message' => 'Post Updated')
        );
    }
    else
    {
        echo json_encode(
            array('message' => 'Post Not Updated')
        );
    }