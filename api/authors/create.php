<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: authors/create.php


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

    $author->author = $data->author;
    

    // Create Author
    if($author->create())
    {
        echo json_encode(
            array('message' => 'Author Created')
        );
    }
    else
    {
        echo json_encode(
            array('message' => 'Author Not Created')
        );
    }