<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: login/login_page.php");
  exit();
}

require_once "common_functions.php";

if (isset($_POST['update'])) {
  $user_id = $_POST['user_id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($name) || empty($email) || empty($password)) {
    $_SESSION['error'] = "Please fill in all the fields.";
    header("Location: index.php");
    exit();
  }

  $success = updateUser($user_id, $name, $email, $password);
  if ($success) {
    $_SESSION['success'] = "User information updated successfully.";
  } else {
    $_SESSION['error'] = "Failed to update user information. Please try again.";
  }

  header("Location: index.php");
  exit();
} else {
  header("Location: index.php");
  exit();
}
?>
