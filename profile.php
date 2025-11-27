<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];

// Fetch logged-in user info
$user_stmt = $conn->prepare("SELECT first_name, last_name, course, year_level, about FROM users WHERE username = ?");
$user_stmt->execute([$username]);
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

$full_name = $user['first_name'] . " " . $user['last_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Records - Smart Campus Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="cake.png"/>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

<nav class="navbar sticky-top navbar-dark" style="background-color: #06326b;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="cake.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
      <u>Smart Campus App</u>
    </a>
  </div>
</nav>

<div class="main-container">
    <div class="sidebar text-white p-3">        
        <a href="index.php" class="text-white d-block mb-3">Profile</a>
        <a href="subjects.php" class="text-white d-block mb-3">Subjects</a>
        <a href="records.php" class="text-warning fw-bold d-block mb-3">Records</a>
        <a href="ecd.php" class="text-white d-block mb-3">ECD</a>
        <a href="about.php" class="text-white d-block mb-3">About</a>
        <a href="logout.php" class="btn btn-danger mt-5">Sign Out</a>
    </div>

<main>
    <div class="profile-pic">
        <div class="placeholder">300 × 300</div>
    </div>

    <div class="profile-info">
        <div class="name"><?php echo htmlspecialchars($full_name); ?></div>

        <div class="course-year">
            <p>COURSE: <?php echo htmlspecialchars($user['course']); ?></p>
            <p>YEAR: <?php echo htmlspecialchars($user['year_level']); ?></p>
        </div>

        <div class="about">
            <p>About: <?php echo htmlspecialchars($user['about']); ?></p>
        </div>

        <a href="edit_profile.php" class="btn btn-primary mt-3">Edit Profile</a>
    </div>
</main>

</div>

</body>
</html>
