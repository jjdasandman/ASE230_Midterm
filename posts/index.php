<?php
include '../utils.php';
$posts = loadPostsFromJSON('../posts.json');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Blog Posts</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="my-4">All Blog Posts</h1>
    
    <!-- Authentication buttons -->
    <div class="mb-4">
        <?php if (isLoggedIn()) { ?>
            <p>Welcome, <?php echo getCurrentUser(); ?>!</p>
            <a href="../auth/logout.php" class="btn btn-danger">Sign Out</a>
        <?php } else { ?>
            <a href="../auth/login.php" class="btn btn-primary">Sign In</a>
            <a href="../auth/signup.php" class="btn btn-secondary">Sign Up</a>
        <?php } ?>
    </div>

    <!-- Button to create a new post (if logged in) -->
    <?php if (isLoggedIn()) { ?>
        <a href="create.php" class="btn btn-success mb-3">Create New Post</a>
    <?php } ?>

    <!-- Display posts -->
    <?php displayPosts($posts); ?>
</div>
</body>
</html>
