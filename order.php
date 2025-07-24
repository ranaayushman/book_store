<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_id'])) {

    $order_id = "BK-" . strtoupper(uniqid());
    
    $book_api_id = filter_input(INPUT_POST, 'book_id', FILTER_SANITIZE_STRING);
    $book_title = filter_input(INPUT_POST, 'book_title', FILTER_SANITIZE_STRING);

    $db->orders->insertOne([
        'order_id' => $order_id,
        'user_id' => new MongoDB\BSON\ObjectID($_SESSION['user_id']),
        'book_api_id' => $book_api_id,
        'book_title' => $book_title,
        'order_date' => new MongoDB\BSON\UTCDateTime()
    ]);

    $_SESSION['last_order_id'] = $order_id;

    header('Location: confirmation.php');
    exit;
} else {

    header('Location: index.php');
    exit;
}
?>
