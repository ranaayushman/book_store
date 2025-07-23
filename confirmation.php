<?php
// confirmation.php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['last_order_id'])) {
    header('Location: index.php');
    exit;
}

$last_order_id = $_SESSION['last_order_id'];
// You could fetch the full order details here to show more info
?>

<!DOCTYPE html>
<html>
<head><title>Order Confirmation</title></head>
<body>
    <h1>Thank You For Your Order!</h1>
    <p>Your order has been placed successfully.</p>
    <p><strong>Your Order ID is: <?php echo htmlspecialchars($last_order_id); ?></strong></p>
    <a href="index.php">Continue Shopping</a>
</body>
</html>

<?php
// Unset the session variable so it's not shown again on refresh
unset($_SESSION['last_order_id']);
?>