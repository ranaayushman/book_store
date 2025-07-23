<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$connection_string = $_ENV['MONGODB_URI'];

$client = new MongoDB\Client($connection_string);

$db = $client->bookstore;
?>
