<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: index.php

// Model Requirements
require('./model/database.php');
require('./model/authors_db.php');
require('./model/categories_db.php');
require('./model/quotes_db.php');

// Variables
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if(!$action)
{
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
    if(!$action)
    {
        $action = 'default';
    }
}

$categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_VALIDATE_INT);
if(!$categoryId)
{
    $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);
}

$authorId = filter_input(INPUT_POST, 'authorId', FILTER_VALIDATE_INT);
if(!$authorId)
{
    $authorId = filter_input(INPUT_GET, 'authorId', FILTER_VALIDATE_INT);
}

$quote_id = filter_input(INPUT_POST, 'quote_id', FILTER_VALIDATE_INT);
if(!$quote_id)
{
    $quote_id = filter_input(INPUT_GET, 'quote_id', FILTER_VALIDATE_INT);
}

$quote_name = filter_input(INPUT_POST, 'quote_name', FILTER_SANITIZE_STRING);
if(!$quote_name)
{
    $quote_name = filter_input(INPUT_GET, 'quote_name', FILTER_SANITIZE_STRING);
}


// Start Cookie Session
$lifetime = 60 * 60 * 24 * 14; // cookie will last 2 weeks
session_set_cookie_params($lifetime, '/');
session_start();

// Connect to DB
$database = new Database();
$db = $database->connect();

// Instantiate Objects
$quotes = new Quotes($db);
$authors = new Authors($db);
$categories = new Categories($db);



// Action Switch
switch($action)
{
    case "search_quotes":
        if($authorId && $categoryId)
        {
            $quotes->authorId = $authorId;
            $quotes->categoryId = $categoryId;
            $quotes = $quotes->get_quotes_by_all();
            $authors = $authors->read();
            $categories = $categories->read();
            include('view/list_quotes.php');
            break;
        }
        else if($authorId)
        {
            $quotes->authorId = $authorId;
            $quotes = $quotes->get_author_quotes($authorId);
            $authors = $authors->read();
            $categories = $categories->read();
            include('view/list_quotes.php');
            break;
        }
        else if($categoryId)
        {
            $quotes->categoryId = $categoryId;
            $quotes = $quotes->get_category_quotes($categoryId);
            $authors = $authors->read();
            $categories = $categories->read();
            include('view/list_quotes.php');
            break;
        }
        else
        {
            // reload page with default action to pull in all quotes
            header("Location: .?action=default");
            break;
        }
    case "edit_quotes":
        $quotes = $quotes->read();
        $authors = $authors->read();
        $categories = $categories->read();
        include('view/edit_quotes.php');
        break;
    case "add_quote":
        $quotes->authorId = $authorId;
        $quotes->categoryId = $categoryId;
        $quotes->quote = $quote_name;
        $quotes = $quotes->add_quote($quotes->quote, $quotes->authorId, $quotes->categoryId);
        $categoryId = null;
        $authorId = null;
        header("Location: .?action=default");
        break;
    default:
        $quotes = $quotes->read();
        $authors = $authors->read();
        $categories = $categories->read();
        include('view/list_quotes.php');
        break;
}
?>


