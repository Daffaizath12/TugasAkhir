<?php

// Database connection
$db = mysqli_connect('localhost', 'root', '', 'travelapps');
if (!$db) {
 die("Connection failed: " . mysqli_connect_error());
}

// Function to verify OTP and email
function verifyOTP($email, $otp)
{
 global $db;

 // Check if the OTP is valid for the given email in 'user' table
 $sqlUser = "SELECT * FROM user WHERE email = '" . mysqli_real_escape_string($db, $email) . "' AND reset_password_otp = '" . mysqli_real_escape_string($db, $otp) . "'";
 $resultUser = mysqli_query($db, $sqlUser);

 if ($resultUser && mysqli_num_rows($resultUser) > 0) {
  return true; // OTP verified successfully in 'user' table
 }

 // Check if the OTP is valid for the given email in 'sopir' table
 $sqlSopir = "SELECT * FROM sopir WHERE email = '" . mysqli_real_escape_string($db, $email) . "' AND reset_password_otp = '" . mysqli_real_escape_string($db, $otp) . "'";
 $resultSopir = mysqli_query($db, $sqlSopir);

 if ($resultSopir && mysqli_num_rows($resultSopir) > 0) {
  return true; // OTP verified successfully in 'sopir' table
 }

 return false; // Invalid OTP for the given email in both tables
}

// API endpoint to verify OTP and email
if (!empty($_POST['email']) && !empty($_POST['otp'])) {
 $email = $_POST['email'];
 $otp = $_POST['otp'];

 // Verify OTP and email
 $otpVerified = verifyOTP($email, $otp);

 if ($otpVerified) {
  // echo "OTP verified successfully";
  echo json_encode(array('success' => true, 'message' => 'OTP verified successfully'));
 } else {
  // echo "Invalid OTP for the given email";
  echo json_encode(array('success' => false, 'message' => 'Invalid OTP for the given email'));
 }
} else {
 // echo "Email and OTP are required";
 echo json_encode(array('success' => false, 'message' => 'Email and OTP are required'));
}
