<?php
require 'db.php';

if (!isset($_SESSION['bloggerID'])) {
    header("Location: login.php");
    exit;
}

// Create post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post'])) {
    $post = $db->real_escape_string($_POST['post']);
    $bloggerID = $_SESSION['bloggerID'];
    $db->query("INSERT INTO blog_system_post (bloggerID, post) VALUES ($bloggerID, '$post')");
}

// Comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = $db->real_escape_string($_POST['comment']);
    $postID = (int)$_POST['postID'];
    $bloggerID = $_SESSION['bloggerID'];
    $viewerName = $db->real_escape_string($_POST['viewerName']);

    $db->query("INSERT INTO blog_system_viewer (name, postID) VALUES ('$viewerName', $postID)");
    $viewerID = $db->insert_id;

    $db->query("INSERT INTO blog_system_comments (bloggerID, postID, comment, viewerID)
                VALUES ($bloggerID, $postID, '$comment', $viewerID)");
}

$posts = $db->query("SELECT * FROM blog_system_post ORDER BY created_at DESC");
?>

<h2>Welcome <?= htmlspecialchars($_SESSION['username']) ?> | <a href="logout.php">Logout</a></h2>

<h3>Create a Post</h3>
<form method="POST">
    <textarea name="post" required placeholder="Write something..."></textarea><br>
    <button type="submit">Post</button>
</form>

<hr>

<h3>All Posts</h3>
<?php while ($post = $posts->fetch_assoc()): ?>
    <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
        <p><?= htmlspecialchars($post['post']) ?></p>
        <small>Posted on <?= $post['created_at'] ?></small>

        <h4>Comments</h4>
        <?php
        $comments = $db->query("SELECT c.comment, v.name, c.created_at 
                                FROM blog_system_comments c
                                JOIN blog_system_viewer v ON c.viewerID = v.viewerID
                                WHERE c.postID = {$post['postID']} ORDER BY c.created_at DESC");
        while ($c = $comments->fetch_assoc()):
        ?>
            <div style="margin-left: 20px;">
                <strong><?= htmlspecialchars($c['name']) ?>:</strong> <?= htmlspecialchars($c['comment']) ?><br>
                <small><?= $c['created_at'] ?></small>
            </div>
        <?php endwhile; ?>

        <form method="POST">
            <input type="hidden" name="postID" value="<?= $post['postID'] ?>">
            <input type="text" name="viewerName" required placeholder="Your name"><br>
            <textarea name="comment" required placeholder="Write a comment..."></textarea><br>
            <button type="submit">Comment</button>
        </form>
    </div>
<?php endwhile; ?>