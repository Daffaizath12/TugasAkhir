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

 // Check if the OTP is valid for the given email
 $sql = "SELECT * FROM sopir WHERE email = '$email' AND reset_password_otp = '$otp'";
 $result = mysqli_query($db, $sql);
 if ($result && mysqli_num_rows($result) > 0) {
  return true; // OTP verified successfully
 } else {
  return false; // Invalid OTP for the given email
 }
}

// API endpoint to verify OTP and email
if (!empty($_POST['email']) && !empty($_POST['otp'])) {
 $email = $_POST['email'];
 $otp = $_POST['otp'];

 // Verify OTP and email
 $otpVerified = verifyOTP($email, $otp);

 if ($otpVerified) {
  echo "OTP verified successfully";
 } else {
  echo "Invalid OTP for the given email";
 }
} else {
 echo "Email and OTP are required";
}
