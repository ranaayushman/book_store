<?php
// order.php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_id'])) {
    $order_id = "ORDER-" . strtoupper(uniqid()); // Generate a unique order ID
    
    $db->orders->insertOne([
        'order_id' => $order_id,
        'user_id' => new MongoDB\BSON\ObjectID($_SESSION['user_id']),
        'book_id' => new MongoDB\BSON\ObjectID($_POST['book_id']),
        'order_date' => new MongoDB\BSON\UTCDateTime()
    ]);

    // Save order ID in session to show on confirmation page
    $_SESSION['last_order_id'] = $order_id;

    header('Location: confirmation.php');
    exit;
}