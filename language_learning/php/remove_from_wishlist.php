<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$course_name = $_POST['course'];

// Prepare the query to remove the course from the wishlist
$query = "DELETE FROM wishlist WHERE user_id = ? AND course_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $user_id, $course_name);
$stmt->execute();

// Redirect back to the wishlist page
header("Location: wishlist.php");
exit();
?>
