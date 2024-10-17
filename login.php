<?php
include 'db.php';
session_start();

// Handle user signup
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email']; // Get email from the form
    
    // Check if username or email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        echo "Username or email already exists!";
    } else {
        // Insert new user into the database without hashing the password
        $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $password, $email])) {
            echo "Signup successful! You can now log in.";
        } else {
            echo "Error: Could not sign up.";
        }
    }
}

// Handle user login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve the user from the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Verify the password (direct comparison without hashing)
    if ($user && $password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: ../dashboard.php');
        exit;
    } else {
        echo "Invalid login credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Login/Signup</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit" name="login">Login</button>
    </form>

    <h1>Sign Up</h1>
    <form method="POST">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        Email: <input type="email" name="email" required><br> <!-- Added email input -->
        <button type="submit" name="signup">Sign Up</button>
    </form>
</body>
</html>
