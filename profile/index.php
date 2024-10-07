<?php

include '../utils.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

$username = $_SESSION['username'];
$posts = loadPostsFromJSON('../posts.json');


// Function to display the user's posts
function displayUserPosts($posts, $username) {
    foreach ($posts as $index => $post) {
        if ($post['author'] === $username) {
            $post_id = $index; // Use the index as the post ID
            echo "<div class='card my-3'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'><a href='../posts/detail.php?post_id={$post_id}'>{$post['title']}</a></h5>";
            echo "<p class='card-text'>By {$post['author']} on {$post['date']}</p>";
            echo "</div>";
            echo "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">User Profile</h1>
        <p>Welcome, <?php echo $username; ?>!</p>
        <h2>Your Posts</h2>
        <?php displayUserPosts($posts, $username); ?>
		<a href="../posts/index.php" class="btn btn-primary">Back</a>
        <a href="../profile/settings.php" class="btn btn-secondary">Account Settings</a>
        <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
