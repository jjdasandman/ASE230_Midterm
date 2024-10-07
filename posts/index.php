<?php
include '../utils.php';
$posts = loadPostsFromJSON('../posts.json');

// Handle sorting logic
if (isset($_POST['sort'])) {
    $sortOption = $_POST['sort'];
    
    switch ($sortOption) {
        case 'date_asc':
            usort($posts, function($a, $b) {
                return strtotime($a['date']) - strtotime($b['date']);
            });
            break;
        case 'date_desc':
            usort($posts, function($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });
            break;
        case 'author_az':
            usort($posts, function($a, $b) {
                return strcmp($a['author'], $b['author']);
            });
            break;
        case 'author_za':
            usort($posts, function($a, $b) {
                return strcmp($b['author'], $a['author']);
            });
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Blog Posts</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            margin-bottom: 20px;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover; /* Ensures the image covers the area */
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="my-4">All Blog Posts</h1>

    <!-- Authentication buttons -->
    <div class="mb-4">
        <?php if (isLoggedIn()) { ?>
            <p>Welcome, <?php echo getCurrentUser(); ?>!</p>
            <a href="../auth/logout.php" class="btn btn-danger">Sign Out</a>
            <a href="../profile/index.php" class="btn btn-primary">Profile</a>
            <a href="../profile/settings.php" class="btn btn-secondary">Settings</a>
        <?php } else { ?>
            <a href="../auth/login.php" class="btn btn-primary">Sign In</a>
            <a href="../auth/signup.php" class="btn btn-secondary">Sign Up</a>
        <?php } ?>
    </div>
	<div class="mb-4 d-flex justify-content-between align-items-center">
		<!-- Button to create a new post (if logged in) -->
		<?php if (isLoggedIn()) { ?>
			<a href="create.php" class="btn btn-success">Create New Post</a>
		<?php } ?>

		<!-- Sort dropdown -->
		<form method="POST" class="form-inline mb-0 ms-auto">
			<div class="form-group">
				<label for="sort" class="sr-only">Sort By</label>
				<select name="sort" id="sort" class="form-control" onchange="this.form.submit()">
					<option value="">Sort By</option>
					<option value="date_asc">Date Ascending</option>
					<option value="date_desc">Date Descending</option>
					<option value="author_az">Author A-Z</option>
					<option value="author_za">Author Z-A</option>
				</select>
			</div>
		</form>
	</div>

    <!-- Display posts in a grid -->
    <div class="row">
        <?php foreach ($posts as $post): ?>
            <div class="col-md-4"> <!-- Change this value to adjust the number of columns -->
                <div class="card">
                    <!-- <img src="path/to/default/image.jpg" class="card-img-top" alt="Post Image"> <!-- Placeholder image -->
                    <div class="card-body">
                        <h5 class="card-title"><a href="detail.php?post_id=<?php echo ($post['id']-1); ?>"><?php echo htmlspecialchars($post['title']); ?></a></h5>
                        <p class="card-text">By <?php echo htmlspecialchars($post['author']); ?> on <?php echo htmlspecialchars($post['date']); ?></p>
                        <p class="card-text"><?php echo htmlspecialchars(substr($post['content'], 0, 100)) . '...'; ?></p> <!-- Preview of content -->
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
