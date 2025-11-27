<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];

// Fetch logged-in user info
$stmt = $conn->prepare("SELECT first_name, last_name, course, year_level, about FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile - Smart Campus Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="cake.png"/>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

<nav class="navbar sticky-top navbar-dark" style="background-color: #06326b;">
  <div class="container-fluid">
    <a class="navbar-brand" href="records.php">
      <img src="cake.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
      <u>Smart Campus App</u>
    </a>
  </div>
</nav>

<div class="main-container">
    <div class="sidebar text-white p-3">        
        <a href="index.php" class="text-white d-block mb-3">Profile</a>
        <a href="subjects.php" class="text-white d-block mb-3">Subjects</a>
        <a href="records.php" class="text-white d-block mb-3">Records</a>
        <a href="ecd.php" class="text-white d-block mb-3">ECD</a>
        <a href="about.php" class="text-white d-block mb-3">About</a>
        <a href="logout.php" class="btn btn-danger mt-5">Sign Out</a>
    </div>

<main class="p-5" style="width: 100%;">

    <div class="container" style="max-width: 600px;">
        <h3 class="mb-4 text-center fw-bold">Edit Profile</h3>

        <div class="card shadow">
            <div class="card-body p-4">

                <form action="save_profile.php" method="POST">

                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control"
                               value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control"
                               value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">About</label>
                        <textarea name="about" class="form-control" rows="4"><?php 
                            echo htmlspecialchars($user['about']); 
                        ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="records.php" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</main>

</div>

</body>
</html>
