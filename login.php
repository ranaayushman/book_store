<?php
// login.php
session_start();
require 'db.php';

// --- SIGNUP LOGIC ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password!

    $db->users->insertOne([
        'name' => $name,
        'email' => $email,
        'password' => $password
    ]);
    echo "Signup successful! Please login.";
}

// --- LOGIN LOGIC ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $user = $db->users->findOne(['email' => $email]);

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = (string)$user['_id'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: index.php'); // Redirect to homepage
        exit;
    } else {
        echo "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login / Signup</title></head>
<body>
    <h2>Signup</h2>
    <form action="login.php" method="post">
        <input type="hidden" name="signup">
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Signup</button>
    </form>

    <hr>

    <h2>Login</h2>
    <form action="login.php" method="post">
        <input type="hidden" name="login">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>