<?php
// details.php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get book ID from URL
$book_id = $_GET['id'];
$book = $db->books->findOne(['_id' => new MongoDB\BSON\ObjectID($book_id)]);

if (!$book) {
    echo "Book not found!";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title><?php echo htmlspecialchars($book['title']); ?></title></head>
<body>
    <a href="index.php"><< Back to list</a>
    <h1><?php echo htmlspecialchars($book['title']); ?></h1>
    <h3>by <?php echo htmlspecialchars($book['author']); ?></h3>
    <p><strong>Price:</strong> $<?php echo htmlspecialchars($book['price']); ?></p>
    <p><?php echo htmlspecialchars($book['description']); ?></p>

    <form action="order.php" method="post">
        <input type="hidden" name="book_id" value="<?php echo $book['_id']; ?>">
        <button type="submit">Order Now</button>
    </form>
</body>
</html>