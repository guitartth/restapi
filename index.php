<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: index.php

// Model Requirements
require('./model/database.php');
require('./model/authors_db.php');
require('./model/categories_db.php');
require('./quotes_db.php');

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

$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
if(!$category_id)
{
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
}

$author_id = filter_input(INPUT_POST, 'author_id', FILTER_VALIDATE_INT);
if(!$author_id)
{
    $author_id = filter_input(INPUT_GET, 'author_id', FILTER_VALIDATE_INT);
}

$quote_id = filter_input(INPUT_POST, 'quote_id', FILTER_VALIDATE_INT);
if(!$quote_id)
{
    $quote_id = filter_input(INPUT_GET, 'quote_id', FILTER_VALIDATE_INT);
}

$quote_name = filter_input(INPUT_POST, 'quote_name', FILTER_SANITIZE_STRING);


// Start Cookie Session
$lifetime = 60 * 60 * 24 * 14; // cookie will last 2 weeks
session_set_cookie_params($lifetime, '/');
session_start();


// Action Switch
switch($action)
{
    case "filter_quotes":
        if($author_id && $category_id)
        {
            $quotes = Quotes::get_quotes_by_all($author_id, $category_id);
            $authors = Authors::get_authors();
            $categories = Categories::get_categories();
            include('view/list_quotes.php');
            break;
        }
        else if($author_id)
        {
            $quotes = Quotes::get_quotes_by_author($author_id);
            $authors = Authors::get_authors();
            $categories = Categories::get_categories();
            include('view/list_quotes.php');
            break;
        }
        else if($category_id)
        {
            $quotes = Quotes::get_quotes_by_category($category_id);
            $authors = Authors::get_authors();
            $categories = Categories::get_categories();
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
        $quotes = Quotes::get_quotes();
        $authors = Authors::get_authors();
        $categories = Categories::get_categories();
        include('view/edit_quotes.php');
        break;
    case "add_quote":
        Quotes::add_quote($quote_name, $author_id, $category_id);
        header("Location: .?action=default");
        break;
    default:
        $quotes = Quotes::get_quotes();
        $authors = Authors::get_authors();
        $categories = Categories::get_categories();
        include('view/list_quotes.php');
        break;
}
?>


<h1>Hello World!</h1>