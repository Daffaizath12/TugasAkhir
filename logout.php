<?php
// Mulai atau resume session
session_start();

// Hapus semua variabel sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login atau halaman lainnya
header("Location: login.php");
exit;
?>
