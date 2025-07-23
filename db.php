<?php
// db.php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->bookstore; // Your database will be named "bookstore"
?>