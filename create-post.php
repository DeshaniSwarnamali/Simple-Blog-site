<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
    $stmt->execute([$title, $content, $user_id]);
    echo "Post created successfully!";
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/post.css">
    <title>Dashboard</title>
</head>
<form method="POST">
    Title: <input type="text" name="title" required><br>
    Content: <textarea name="content" required></textarea><br>
    <button type="submit">Create Post</button>
</form>
