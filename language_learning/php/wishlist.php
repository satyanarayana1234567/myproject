<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: ../html/login.html");
  exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT course_name FROM wishlist WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Learn Languages Online</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="../Js/home.js" defer></script>
  <!-- <link rel="stylesheet" href="../CSS/home.css"> -->
<style>
    body {
    min-height: 100vh; /* Ensure the body takes up the full height */
    display: flex;
    flex-direction: column;
}

footer {
    margin-top: auto;
     /* Pushes the footer to the bottom */
     /* position: sticky; */
     bottom: 0;
     width: 100%;
}

</style>

</head>
<body class="bg-gradient-to-br from-blue-50 to-white font-sans">

      <!-- Sidebar -->
      <div id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-white shadow-lg z-40 border-r transform -translate-x-full transition-transform duration-300">
        <div class="p-5 border-b font-bold text-xl text-blue-700 flex justify-between items-center">
          📚 Menu
          <button onclick="toggleSidebar()" class="text-blue-600 hover:text-blue-800">
            &times; <!-- Close icon -->
          </button>
        </div>
        <ul class="p-5 space-y-4 text-gray-700">
        <li class="flex items-center gap-2">
            <img src="../UiMedia/home.png" alt="Courses Icon" class="w-5 h-5">
            <a href="../html/home.html" class="hover:text-blue-600 transition">Home</a>
            </li>
          <li class="flex items-center gap-2">
            <img src="../UiMedia/courses.png" alt="Courses Icon" class="w-5 h-5">
            <a href="../html/courses.html" class="hover:text-blue-600 transition">Courses</a>
          </li>
          <li class="flex items-center gap-2">
            <img src="../UiMedia/enrolled.png" alt="Enrolled Icon" class="w-5 h-5">
            <a href="wishlist.php" class="hover:text-blue-600 transition">Enrolled Courses</a>
          </li>
          <li class="flex items-center gap-2">
            <img src="../UiMedia/feedback.png" alt="Feedback Icon" class="w-5 h-5">
            <a href="../html/feedback.html" class="hover:text-blue-600 transition">Feedbacks</a>
          </li>
          <li class="flex items-center gap-2">
            <img src="../UiMedia/writeus.png" alt="About Us Icon" class="w-5 h-5">
            <a href="../html/aboutus.html" class="hover:text-blue-600 transition">About us</a>
          </li>
        </ul>
      </div>
    
      <!-- Header -->
      <header class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center shadow-md sticky top-0 z-30">
        <div class="flex items-center gap-3">
          <img src="../UiMedia/menuWhite2.png"
               class="w-6 h-6 cursor-pointer"
               onclick="toggleSidebar()" />
          <h1 class="text-2xl font-bold">Learn Languages Online</h1>
        </div>
        <div class="hidden md:flex gap-2"> <!-- Hide on small screens -->
          <a href="../html/home.html"><img src="../UiMedia/whiteHome.png" alt="Home Icon" class="w-8 h-8 mt-[4px] "></a>
          <a href="dashboard.php"><img src="../UiMedia/whiteProfile.png" alt="Profile Icon" class="w-8 h-8 mt-[4px] "></a>
      
        </div>
        <div class="md:hidden flex gap-2"> <!-- Show on small screens -->
      
        </div>
      </header>

      <body class="bg-gray-100 p-6 font-sans">
      <h1 class="text-2xl font-bold mb-4 text-center">📌 My Courses</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
      <?php while ($row = $result->fetch_assoc()): ?>

        <!-- ⚠️changed here -->
        <div class="bg-[url('../UiMedia/wishlistCover.png')] bg-cover bg-center h-64 w-full">

            <div class="p-4 rounded-lg shadow text-center">
              <h2 class="text-lg font-semibold capitalize"><?= htmlspecialchars($row['course_name']) ?></h2>
              <a href="playlist.php?course=<?= urlencode($row['course_name']) ?>" class="text-blue-500 hover:underline">View Course</a>
              
              <!-- Remove button -->
              <form action="remove_from_wishlist.php" method="POST" class="mt-2">
                <input type="hidden" name="course" value="<?= htmlspecialchars($row['course_name']) ?>">
                <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded-2xl hover:bg-red-600 w-full text-center">Remove from Wishlist</button>
              </form>
            </div>

        </div>
      <?php endwhile; ?>
    </div>
  <script>
    let isSidebarOpen = false; // Track the sidebar state

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      isSidebarOpen = !isSidebarOpen; // Toggle the state
      sidebar.style.transform = isSidebarOpen ? 'translateX(0)' : 'translateX(-100%)';
    }

    // Close sidebar when clicking outside of it
    document.addEventListener('click', function(event) {
      const sidebar = document.getElementById('sidebar');
      const menuButton = document.querySelector('img[onclick="toggleSidebar()"]');

      // Check if the click was outside the sidebar and the menu button
      if (isSidebarOpen && !sidebar.contains(event.target) && !menuButton.contains(event.target)) {
        toggleSidebar(); // Close the sidebar
      }
    });

    // Close sidebar on mouse leave
    document.getElementById('sidebar').addEventListener('mouseleave', function() {
      if (isSidebarOpen) {
        toggleSidebar(); // Close the sidebar
      }
    });
</script>

  <!-- Footer -->
  <footer class="bg-blue-600 text-white text-center py-5 mt-16">
    © 2025 LearnLanguagesOnline.com | All rights reserved.
  </footer>
</body>
</html>



