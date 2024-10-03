<?php
include '../utils.php';

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $posts = loadPostsFromJSON('../posts.json');
    $post = getPost($posts, $post_id);

    if (!$post) {
        echo "Post not found.";
        exit();
    }
} else {
    echo "No post specified.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post['title']; ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="my-4"><?php echo $post['title']; ?></h1>
    <p>By <?php echo $post['author']; ?> on <?php echo $post['date']; ?></p>
    <p><?php echo $post['content']; ?></p>

    <!-- Buttons to edit and delete (only for the author) -->
    <?php if (isLoggedIn() && getCurrentUser() === $post['author']) { ?>
        <a href="edit.php?post_id=<?php echo $post_id; ?>" class="btn btn-warning">Edit Post</a>
        <a href="delete.php?post_id=<?php echo $post_id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete Post</a>
    <?php } ?>

    <a href="index.php" class="btn btn-secondary mt-3">Back to Blog Index</a>
</div>
</body>
</html>
