<?php
// index.php
session_start();
require 'db.php';

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch all books from the database
$books = $db->books->find();
?>

<!DOCTYPE html>
<html>
<head><title>Bookstore Home</title></head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
    <a href="logout.php">Logout</a>
    <hr>
    <h2>Our Books</h2>
    <div class="book-list">
        <?php foreach ($books as $book): ?>
            <div class="book-item">
                <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                <p>by <?php echo htmlspecialchars($book['author']); ?></p>
                <a href="details.php?id=<?php echo $book['_id']; ?>">View Details</a>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>
</body>
</html>