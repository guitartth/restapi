<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: categories/read_single.php


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

    // Get ID
    $category->categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);

    // Get Category
    $category->get_single_category();

    // Create Array
    $cat_arr = array(
        'categoryId' => $category->categoryId,
        'category' => $category->category,
    );

    // Turn to JSON
    print_r(json_encode($cat_arr));