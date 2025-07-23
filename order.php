<?php
// /var/www/html/order.php

session_start();
require 'db.php';

// Security check: ensure user is logged in before they can order.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Process the order only if it's a POST request with a book_id.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_id'])) {
    // Generate a simple, unique order ID.
    $order_id = "BK-" . strtoupper(uniqid());
    
    // Get book details from the form submission
    $book_api_id = filter_input(INPUT_POST, 'book_id', FILTER_SANITIZE_STRING);
    $book_title = filter_input(INPUT_POST, 'book_title', FILTER_SANITIZE_STRING);

    // Insert the new order into the 'orders' collection.
    // We store the API ID and title instead of the MongoDB ObjectID for the book.
    $db->orders->insertOne([
        'order_id' => $order_id,
        'user_id' => new MongoDB\BSON\ObjectID($_SESSION['user_id']),
        'book_api_id' => $book_api_id,
        'book_title' => $book_title,
        'order_date' => new MongoDB\BSON\UTCDateTime()
    ]);

    // Store the new order ID in the session so the confirmation page can display it.
    $_SESSION['last_order_id'] = $order_id;

    // Redirect to the confirmation page.
    header('Location: confirmation.php');
    exit;
} else {
    // If accessed directly or without data, redirect to the homepage.
    header('Location: index.php');
    exit;
}
?>
