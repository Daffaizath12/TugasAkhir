<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "../vendor/autoload.php";

header('Content-Type: application/json');

// if (!empty($_POST['email'])) {
$db = mysqli_connect('localhost', 'root', '', 'travelapps');
$email = $_POST['email'];

if ($db) {
  // Check email in the 'user' table
  $query = "SELECT * FROM user WHERE email = '" . mysqli_real_escape_string($db, $email) . "'";
  $resultUser = mysqli_query($db, $query);

  if (mysqli_num_rows($resultUser) > 0) {
    $table = 'user';
  } else {
    echo json_encode(array('success' => false, 'message' => 'Email not found'));
    exit;
  }

  try {
    $otp = random_int(100000, 999999);
  } catch (Exception $e) {
    $otp = rand(100000, 999999);
  }

  $sql = "UPDATE $table SET reset_password_otp = '" . $otp . "', password_created_at = '" . date('Y-m-d H:i:s') . "' WHERE email = '" . mysqli_real_escape_string($db, $email) . "'";

  if (mysqli_query($db, $sql)) {
    if (mysqli_affected_rows($db)) {
      $mail = new PHPMailer();
      try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        $mail->isSMTP();
        $mail->Host = "smtp.example.com";
        $mail->Port =  465;
        $mail->SMTPAuth = true;
        $mail->Username   = 'suketkepuharjo@gmail.com';
        $mail->Password   = 'hske pghu dkmy fwpj';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        // $mail->Port       = 25;

        //Recipients
        $mail->setFrom('from@example.com', 'PETTA EXPRESS');
        $mail->addAddress($email);
        $mail->addReplyTo('info@example.com', 'Information');

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password';
        $mail->Body    = 'Your OTP to reset Password is [' . $otp . ']';
        $mail->AltBody = 'Reset password to access codes easy application';

        if ($mail->send()) {
          echo json_encode(array('success' => true, 'message' => 'Email sent successfully'));
        } else {
          echo json_encode(array('success' => false, 'message' => 'Failed to send OTP'));
        }
      } catch (Exception $e) {
        echo json_encode(array('success' => false, 'message' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo));
      }
    } else {
      echo json_encode(array('success' => false, 'message' => 'Reset password failed'));
    }
  }
} else {
  echo json_encode(array('success' => false, 'message' => 'DB connection failed'));
}
// } else {
//   echo json_encode(array('success' => false, 'message' => 'All fields are required'));
// }
