<?php
// Include the configuration file to get the API key securely
include('config.php'); 

// Map course names to YouTube playlist IDs
$courseMap = [
    'french-beginner' => 'PLOVSdvQtun0r91XZQuqk109Rjx7Dqw6nb',
    'german-a1' => 'PLYzp2xhTw9W1Z9RvnCoveC0W7pkwUMHXy',
    'spanish' => 'PLYitpHBq-8SXrpjOHu6nU60Uq6QQ6NpIH',
    'english' => 'PLAX41TUzaphC09B9HFfEqOkwBqCk1yE9v',
    'mandarin' => 'PLOZiEc7ESUiE3Jdo1hkWfNvQpxaamHA9L',
    'japanese' => 'PLag_mhJfCJ-18WyYoklCPxIpYbeRgmWLJ',
    'italian' => 'PLUcDBadaP5IUJYW6qn2jTH0Ik2EMvAPze',
    'arabic' => 'PLr_tqbGZylgY_ZGOgGO2KlCLknUPA8g4w',
];

$course = $_GET['course'] ?? '';  // Get the course parameter from the URL
$playlistId = $courseMap[$course] ?? null;  // Look up the playlist ID

$videos = [];

if ($playlistId) {
    // Use the API key from config.php
    $url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=20&playlistId={$playlistId}&key=" . YOUTUBE_API_KEY;
    $response = file_get_contents($url);

    if ($response) {
        $data = json_decode($response, true);
        foreach ($data['items'] as $item) {
            $videoId = $item['snippet']['resourceId']['videoId'];
            $title = $item['snippet']['title'];
            $thumbnail = $item['snippet']['thumbnails']['medium']['url'];
            $videos[] = [
                'videoId' => $videoId,
                'title' => $title,
                'thumbnail' => $thumbnail
            ];
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Learn Languages Online</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="../Js/home.js" defer></script>
  <link rel="stylesheet" href="../CSS/home.css">
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
            <a href="../html/Home.html" class="hover:text-blue-600 transition">Home</a>
            </li>
          <li class="flex items-center gap-2">
            <img src="../UiMedia/courses.png" alt="Courses Icon" class="w-5 h-5">
            <a href="../html/courses.html" class="hover:text-blue-600 transition">Courses</a>
          </li>
          <li class="flex items-center gap-2">
            <img src="../UiMedia/enrolled.png" alt="Enrolled Icon" class="w-5 h-5">
            <a href="../html/enrolledCourses.html" class="hover:text-blue-600 transition">Enrolled Courses</a>
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

      <div class="container">
  <?php if (!$playlistId): ?>
    <p>Invalid or missing course. <a href="courses.html">Go back</a></p>
  <?php else: ?>
    <div class="bg-yellow-300 text-center text-xl font-semibold mb-4 text-blue-700">Learn <?= htmlspecialchars(ucwords(str_replace('-', ' ', $course))) ?> </div>
    <h2>Playlist for: <?= htmlspecialchars(ucwords(str_replace('-', ' ', $course))) ?></h2>

    <?php if (count($videos) > 0): ?>
      <div class="video-player relative w-full max-w-5xl mx-auto">
  <div id="videoThumbnail" class="cursor-pointer relative" onclick="loadVideo()">
    <!-- thumbnail image -->
    <img src="../UiMedia/frenchCover.png" alt="Custom Thumbnail" class="w-full rounded-lg shadow-lg">    
    <div class="absolute inset-0 flex items-center justify-center">
      <img src="../UiMedia/playbuttonblack.png" alt="Play" class="w-16 h-16 opacity-80">
    </div>
  </div>

  <!-- Hidden iframe initially -->
  <iframe 
    id="videoIframe" 
    width="100%" 
    height="450" 
    class="hidden rounded-lg shadow-lg" 
    src="https://www.youtube.com/embed/<?= $videos[0]['videoId'] ?>?autoplay=1" 
    frameborder="0" 
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
    allowfullscreen>
  </iframe>
</div>

      <div class="bg-yellow-300 text-xl font-semibold mb-4 text-blue-700">More Modules</div>
      <!-- <h3 class="text-xl font-semibold mb-4 text-blue-700">More Videos in this Course:</h3> -->
      <div>

      </div>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-2 md:px-4">
  <?php foreach ($videos as $video): ?>
    <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-2 flex flex-col items-center text-center">
      <img 
        src="<?= $video['thumbnail'] ?>" 
        alt="Thumbnail" 
        onclick="changeVideo('<?= $video['videoId'] ?>')" 
        class="cursor-pointer rounded-md w-full h-auto mb-2 hover:scale-105 transition-transform duration-200"
      >
      <p class="text-sm font-medium text-gray-800 line-clamp-2 mb-1"><?= htmlspecialchars($video['title']) ?></p>
      <a href="https://www.youtube.com/watch?v=<?= $video['videoId'] ?>" 
         target="_blank" 
         class="text-blue-600 text-sm hover:underline">
        Watch on YouTube
      </a>
    </div>
  <?php endforeach; ?>
</div>

    <?php else: ?>
      <p>No videos found in this playlist.</p>
    <?php endif; ?>
  <?php endif; ?>
</div>

<script>
function loadVideo() {
  document.getElementById("videoThumbnail").style.display = "none";
  const iframe = document.getElementById("videoIframe");
  iframe.classList.remove("hidden");
  iframe.src += "&autoplay=1"; // Ensure autoplay starts
}



  function changeVideo(videoId) {
    document.getElementById("videoIframe").src = `https://www.youtube.com/embed/${videoId}`;
  }
</script>

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
