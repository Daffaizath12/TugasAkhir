<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "../vendor/autoload.php";

if (!empty($_POST['email'])) {
 $db = mysqli_connect('localhost', 'root', '', 'travelapps');
 $email = $_POST['email'];
 if ($db) {
  try {
   $otp = random_int(100000, 999999);
  } catch (Exception $e) {
   $otp = rand(100000, 999999);
  }
  $sql = "update sopir set reset_password_otp = '" . $otp . "' , password_created_at  = '" . date('Y-m-d H:i:s') . "' where email = '" . $email . "'";
  if (mysqli_query($db, $sql)) {
   if (mysqli_affected_rows($db)) {
    $mail = new PHPMailer(true);
    try {
     $mail->SMTPDebug = SMTP::DEBUG_SERVER;
     $mail->isSMTP();
     $mail->Host       = 'smtp.gmail.com';
     $mail->SMTPAuth   = true;
     $mail->Username   = 'karnando1994@gmail.com';
     $mail->Password   = 'rktz hnyc ykyr gbzh';
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
     $mail->Port       = 465;

     //Recipients
     $mail->setFrom('from@example.com', 'PETTA EXPRESS');
     $mail->addAddress($email);
     $mail->addAddress('ellen@example.com');
     $mail->addReplyTo('info@example.com', 'Information');

     //Content
     $mail->isHTML(true);
     $mail->Subject = 'Reset Password';
     $mail->Body    = 'Your Otp to reset Password is [' . $otp . ']';
     $mail->AltBody = 'Reset password to access codes easy application';

     if ($mail->send())
      echo 'Message has been sent';
     else echo 'Failed to send otp';
    } catch (Exception $e) {
     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
   } else echo 'reset password failed';
  }
 } else {
  echo "db conn failed";
 }
} else {
 echo "All fields is required";
}
