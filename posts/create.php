<?php
include '../utils.php';

if (!isLoggedIn()) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = getCurrentUser();
    $date = date("Y-m-d");

    // Load posts
    $posts = loadPostsFromJSON('../posts.json');

    // Determine the next ID
    $nextId = 1;
    if (count($posts) > 0) {
        $lastPost = end($posts);
        $nextId = $lastPost['id'] + 1;
    }

    // Handling image upload

    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $imagePath = '../uploads/' . basename($image['name']);

        // Move uploaded file to the 'uploads' directory
        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
            echo "Failed to upload image.";
            exit();
        }
    }



    // Add the new post with ID
    $posts[] = [
        'id' => $nextId,
        'title' => $title,
        'content' => $content,
        'author' => $author,
        'date' => $date,
        'image' => $imagePath
    ];

    // Save posts back to the JSON file
    savePostsToJSON('../posts.json', $posts);

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="my-4">Create New Post</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>
        <div class="form-group"> 
            <label for="image">Upload Image</label> 
             <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Submit Post</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
