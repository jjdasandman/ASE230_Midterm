<?php
session_start();
include 'utils.php';

// Redirect to the blog index page
header('Location: posts/index.php');
exit();
?>
