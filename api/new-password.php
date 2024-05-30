<?php

// Database connection
$db = mysqli_connect('localhost', 'root', '', 'travelapps');
if (!$db) {
 die("Connection failed: " . mysqli_connect_error());
}

// Function to update password
function updatePassword($email, $oldPassword, $newPassword)
{
 global $db;

 // Hash the new password
 $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

 // Check if the email exists in 'user' table and retrieve the current password hash
 $queryUser = "SELECT password FROM user WHERE email = '" . mysqli_real_escape_string($db, $email) . "'";
 $resultUser = mysqli_query($db, $queryUser);

 if (mysqli_num_rows($resultUser) > 0) {
  $user = mysqli_fetch_assoc($resultUser);
  $currentPasswordHash = $user['password'];

  // Verify the old password
  if (password_verify($oldPassword, $currentPasswordHash)) {
   // Update password in 'user' table
   $updateSql = "UPDATE user SET password = '$hashedPassword', reset_password_otp = NULL WHERE email = '" . mysqli_real_escape_string($db, $email) . "'";
  } else {
   return array('success' => false, 'message' => 'Old password is incorrect');
  }
 } else {
  return array('success' => false, 'message' => 'Email not found');
 }

 if (mysqli_query($db, $updateSql)) {
  return array('success' => true, 'message' => 'Password updated successfully');
 } else {
  return array('success' => false, 'message' => 'Failed to update password');
 }
}

// API endpoint to update password
if (!empty($_POST['email']) && !empty($_POST['old_password']) && !empty($_POST['new_password'])) {
 $email = $_POST['email'];
 $oldPassword = $_POST['old_password'];
 $newPassword = $_POST['new_password'];

 // Update password
 $passwordUpdated = updatePassword($email, $oldPassword, $newPassword);

 echo json_encode($passwordUpdated);
} else {
 echo json_encode(array('success' => false, 'message' => 'Email, old password, and new password are required'));
}

mysqli_close($db);
