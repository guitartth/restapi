<?php

require('../model/database.php');
require('../model/authors_db.php');
require('../model/categories_db.php');
require('../model/quotes_db.php');

// Connect to DB
$database = new Database();
$db = $database->connect();


?>