<?php
// Include your database connection file
include 'db.php';

// Fetch posts
$query = $pdo->query("SELECT * FROM posts");
$posts = $query->fetchAll(PDO::FETCH_ASSOC);

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $postId = $_POST['post_id'];
    $name = htmlspecialchars($_POST['name']);
    $comment = htmlspecialchars($_POST['comment']);

    $stmt = $pdo->prepare("INSERT INTO comments (post_id, name, comment) VALUES (?, ?, ?)");
    $stmt->execute([$postId, $name, $comment]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <h1>Welcome to the Simple Blog</h1>

    <?php foreach ($posts as $post): ?>
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
        <p><?php echo htmlspecialchars($post['content']); ?></p>

        <!-- Comment Form -->
        <form method="POST">
            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
            <input type="text" name="name" placeholder="Your name" required>
            <textarea name="comment" placeholder="Your comment" required></textarea>
            <button type="submit">Add Comment</button>
        </form>

        <!-- Display Comments -->
        <h3>Comments:</h3>
        <ul>
            <?php
            // Fetch comments for this post
            $stmt = $pdo->prepare("SELECT * FROM comments WHERE post_id = ?");
            $stmt->execute([$post['id']]);
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($comments): 
                foreach ($comments as $comment): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($comment['name']); ?>:</strong>
                        <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                    </li>
                <?php endforeach; 
            else: ?>
                <li>No comments yet.</li>
            <?php endif; ?>
        </ul>
    <?php endforeach; ?>

</body>
</html>
