<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: loginOrg.html");
    exit();
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Learn Languages Online</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="/Js/home.js" defer></script>
  <link rel="stylesheet" href="/CSS/home.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-white font-sans min-h-screen flex flex-col">

  <!-- Main Wrapper -->
  <div class="flex-grow flex flex-col">

    <!-- Sidebar -->
    <div id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-white shadow-lg z-40 border-r transform -translate-x-full transition-transform duration-300">
      <div class="p-5 border-b font-bold text-xl text-blue-700 flex justify-between items-center">
        📚 Menu
        <button onclick="toggleSidebar()" class="text-blue-600 hover:text-blue-800">
          &times;
        </button>
      </div>
      <ul class="p-5 space-y-4 text-gray-700">
        <li class="flex items-center gap-2">
          <img src="../UiMedia/home.png" alt="Home Icon" class="w-5 h-5">
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
        <img src="../UiMedia/menuWhite2.png" class="w-6 h-6 cursor-pointer" onclick="toggleSidebar()" />
        <h1 class="text-2xl font-bold">Learn Languages Online</h1>
      </div>
      <div class="hidden md:flex gap-2">
        <a href="../html/home.html"><img src="../UiMedia/whiteHome.png" alt="Home Icon" class="w-8 h-8 mt-[4px]"></a>
       
      </div>
      <div class="md:hidden flex gap-2">
      <a href="../html/home.html"><img src="../UiMedia/whiteHome.png" alt="Home Icon" class="w-8 h-8 mt-[4px]"></a>
      </div>
    </header>

    <!-- Page Content -->
    <div class="flex flex-col md:flex-row gap-6 p-4">
      <!-- Profile Card (Left) -->
      <div class="bg-white rounded-xl shadow-md p-6 w-full md:w-1/4 min-h-[600px]">
        <div class="flex justify-between items-start mb-4">
          <div class="flex gap-4">
            <div class="w-14 h-14 rounded-full bg-blue-200 flex items-center justify-center text-white text-xs font-bold">
              imgbb.com<br>
              <span class="text-[10px]">image not found</span>
            </div>
            <div>
              <h2 class="text-xl font-semibold"><?= $_SESSION["username"] ?><</h2>
              <p class="text-orange-500 text-sm font-medium">Profile Published</p>
            </div>
          </div>
          <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded-full">Active</span>
        </div>

        <div class="border-t pt-4">
          <div class="flex justify-between items-center mb-3">
            <h3 class="text-gray-800 font-semibold">Personal Information</h3>
            <a href="#" class="text-purple-600 text-sm font-medium hover:underline">✎ Edit</a>
          </div>
          <p class="text-sm text-gray-700 mb-3"><strong>Name:</strong><?= $_SESSION["username"] ?></p>
          <p class="text-sm text-gray-700 mb-3"><strong>Email:</strong><?= $_SESSION["email"]?></p>
          <p class="text-sm text-gray-700 mb-3"><strong>Phone:</strong> <?= $_SESSION["mobile"]?> </p>
          <p class="text-sm text-gray-700 mb-3"><strong>Language Learning:</strong> Spanish (Beginner)</p>
          <p class="text-sm text-gray-700 mb-3"><strong>Learning Goal:</strong> Travel Conversations</p>
        </div>

        <div class="pt-24">
          <h1>Your final destination</h1>
        </div>
      </div>

      <!-- Header Card (Right) -->
      <div class="bg-purple-600 text-white rounded-xl p-6 flex-1 shadow-md h-fit">
        <h1 class="text-3xl font-bold">Language Learning Portal</h1>
        <p class="text-lg mt-1">Welcome back, <?=$_SESSION["username"]?>!</p>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-blue-600 text-white text-center py-5">
    © 2025 LearnLanguagesOnline.com | All rights reserved.
  </footer>

  <!-- JavaScript -->
  <script>
    let isSidebarOpen = false;
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      isSidebarOpen = !isSidebarOpen;
      sidebar.style.transform = isSidebarOpen ? 'translateX(0)' : 'translateX(-100%)';
    }

    document.addEventListener('click', function(event) {
      const sidebar = document.getElementById('sidebar');
      const menuButton = document.querySelector('img[onclick="toggleSidebar()"]');
      if (isSidebarOpen && !sidebar.contains(event.target) && !menuButton.contains(event.target)) {
        toggleSidebar();
      }
    });

    document.getElementById('sidebar').addEventListener('mouseleave', function () {
      if (isSidebarOpen) {
        toggleSidebar();
      }
    });
  </script>
</body>
</html>
