<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['first_name'], $_POST['last_name'], $_POST['about'])) {

    $username = $_SESSION['username'];

    $stmt = $conn->prepare(
        "UPDATE users 
         SET first_name = ?, last_name = ?, about = ?
         WHERE username = ?"
    );

    $stmt->execute([
        $_POST['first_name'], 
        $_POST['last_name'], 
        $_POST['about'], 
        $username
    ]);

    header("Location: records.php");
    exit;
}
?>
