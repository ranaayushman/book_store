<?php
// /var/www/html/confirmation.php
session_start();
require 'db.php';

// Security check: ensure user has just placed an order.
if (!isset($_SESSION['user_id']) || !isset($_SESSION['last_order_id'])) {
    header('Location: index.php');
    exit;
}

$last_order_id = $_SESSION['last_order_id'];
// Unset the session variable immediately after retrieving it so this page can't be refreshed.
unset($_SESSION['last_order_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - The Book Nook</title>
    <link href="/dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">
    <div class="bg-white p-10 rounded-xl shadow-2xl text-center max-w-lg mx-auto">
        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
            <svg class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Thank You For Your Order!</h1>
        <p class="text-gray-600 mb-6">Your order has been placed successfully and is being processed.</p>
        <div class="bg-gray-100 p-4 rounded-md border border-gray-200">
            <p class="text-lg text-gray-800">Your Order ID is: 
                <strong class="font-mono text-blue-600 tracking-wider"><?php echo htmlspecialchars($last_order_id); ?></strong>
            </p>
        </div>
        <a href="index.php" class="mt-8 inline-block bg-blue-500 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-600 transition-colors text-lg">Continue Shopping</a>
    </div>
</body>
</html>
