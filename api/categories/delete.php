<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: categories/delete.php


    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    require('../../model/database.php');
    require('../../model/categories_db.php');

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category Object
    $category = new Categories($db);

    // Get Raw Posted Data
    $data = json_decode(file_get_contents("php://input"));

    // Set Id to Update
    $category->categoryId = $data->categoryId;

    // Update Category
    if($category->delete())
    {
        echo json_encode(
            array('message' => 'Category Deleted')
        );
    }
    else
    {
        echo json_encode(
            array('message' => 'Category Not Deleted')
        );
    }