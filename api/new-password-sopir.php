<?php

// Database connection
$db = mysqli_connect('localhost', 'root', '', 'travelapps');
if (!$db) {
 die("Connection failed: " . mysqli_connect_error());
}

// Function to update password
function updatePassword($email, $newPassword)
{
 global $db;

 // Update the password
 $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
 $updateSql = "UPDATE sopir SET password = '$hashedPassword', reset_password_otp = NULL WHERE email = '$email'";
 if (mysqli_query($db, $updateSql)) {
  return true; // Password updated successfully
 } else {
  return false; // Failed to update password
 }
}

// API endpoint to update password
if (!empty($_POST['email']) && !empty($_POST['new_password'])) {
 $email = $_POST['email'];
 $newPassword = $_POST['new_password'];

 // Update password
 $passwordUpdated = updatePassword($email, $newPassword);

 if ($passwordUpdated) {
  echo "Password updated successfully";
 } else {
  echo "Failed to update password. Please try again later.";
 }
} else {
 echo "Email and new password are required";
}
