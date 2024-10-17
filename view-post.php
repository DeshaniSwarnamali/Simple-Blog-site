<?php
// Include your database connection file
include 'db.php';

// Fetch posts
$query = $pdo->query("SELECT * FROM posts");
$posts = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h1>Welcome to the Simple Blog</h1>

    <?php foreach ($posts as $post): ?>
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    <?php endforeach; ?>

</body>
</html>
