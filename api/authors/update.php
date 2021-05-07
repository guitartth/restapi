<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: authors/update.php


    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    require('../../model/database.php');
    require('../../model/authors_db.php');

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author Object
    $author = new Authors($db);

    // Get Raw Posted Data
    $data = json_decode(file_get_contents("php://input"));

    // Set Id to Update
    $author->authorId = $data->authorId;

    $author->author = $data->author;
    $author->authorId = $data->authorId;

    // Update Author
    if($author->update())
    {
        echo json_encode(
            array('message' => 'Author Updated')
        );
    }
    else
    {
        echo json_encode(
            array('message' => 'Author Not Updated')
        );
    }