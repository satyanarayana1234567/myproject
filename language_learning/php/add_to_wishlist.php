<?php
session_start();
include 'db.php'; // make sure DB connection is working

if (!isset($_SESSION['user_id'])) {
  header("Location: ../html/login.html");
  exit();
}

$user_id = $_SESSION['user_id'];
$course = $_POST['course'] ?? '';

if (!$course) {
  die("Invalid request.");
}

// Check if already in wishlist
$query = "SELECT * FROM wishlist WHERE user_id = ? AND course_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $user_id, $course);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  // Not in wishlist, so insert
  $insert = $conn->prepare("INSERT INTO wishlist (user_id, course_name) VALUES (?, ?)");
  $insert->bind_param("is", $user_id, $course);
  $insert->execute();
}

// Redirect back to courses page
header("Location: ../html/courses.html");
exit();
?>
