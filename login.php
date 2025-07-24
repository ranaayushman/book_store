<?php
session_start();
require 'db.php';

$signup_message = '';
$login_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if ($email && $name && !empty($password)) {
 
        $existingUser = $db->users->findOne(['email' => $email]);
        if ($existingUser) {
            $signup_message = "<p class='text-red-500 text-center mt-4'>An account with this email already exists.</p>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $db->users->insertOne([
                'name' => $name,
                'email' => $email,
                'password' => $hashed_password
            ]);

            $_SESSION['signup_success'] = "Signup successful! Please login.";
            header("Location: login.php");
            exit;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $user = $db->users->findOne(['email' => $email]);

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = (string)$user['_id'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: index.php');
        exit;
    } else {
        $login_error = "<p class='text-red-500 text-center'>Invalid email or password.</p>";
    }
}

if (isset($_SESSION['signup_success'])) {
    $login_error = "<p class='text-green-500 text-center'>" . $_SESSION['signup_success'] . "</p>";
    unset($_SESSION['signup_success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Signup - The Book Nook</title>
    <link href="/dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans py-12">
    <div class="container mx-auto p-4 max-w-sm">
        <div class="bg-white p-6 rounded-xl shadow-lg w-full">
            <!-- Login Form -->
            <h2 class="text-2xl font-bold mb-5 text-center text-gray-800">Welcome Back!</h2>
            <?php echo $login_error; ?>
            <form action="login.php" method="post" class="space-y-4">
                <input type="hidden" name="login">
                <div>
                    <label class="block text-gray-700 mb-1 text-sm font-semibold" for="login-email">Email</label>
                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" type="email" name="email" id="login-email" placeholder="you@example.com" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1 text-sm font-semibold" for="login-password">Password</label>
                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" type="password" name="password" id="login-password" placeholder="••••••••" required>
                </div>
                <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition-colors font-semibold" type="submit">Login</button>
            </form>

            <!-- OR Separator -->
            <div class="my-6 flex items-center">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="mx-4 text-sm text-gray-500 font-semibold">OR</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <!-- Signup Form -->
            <h2 class="text-2xl font-bold mb-5 text-center text-gray-800">Create an Account</h2>
            <?php echo $signup_message; ?>
            <form action="login.php" method="post" class="space-y-4">
                <input type="hidden" name="signup">
                <div>
                    <label class="block text-gray-700 mb-1 text-sm font-semibold" for="name">Name</label>
                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="name" placeholder="Your Name" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1 text-sm font-semibold" for="signup-email">Email</label>
                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" type="email" name="email" id="signup-email" placeholder="you@example.com" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1 text-sm font-semibold" for="signup-password">Password</label>
                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" type="password" name="password" id="signup-password" placeholder="••••••••" required>
                </div>
                <button class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition-colors font-semibold" type="submit">Signup</button>
            </form>
        </div>
    </div>
</body>
</html>
