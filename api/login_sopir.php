<?php

$db = mysqli_connect('localhost', 'root', '', 'travelapps');

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM sopir WHERE username = '" . $username . "'";
$result = mysqli_query($db, $sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    if ($row['status'] == 'non_active') {
        echo json_encode([
            'success' => false,
            'message' => "Akun Anda belum aktif mohon hubungi admin."
        ]);
    } else {
        if (password_verify($password, $row['password'])) {
            echo json_encode([
                'success' => true,
                'message' => "Berhasil Login",
                'user' => $row,
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "Password Salah"
            ]);
        }
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => "Email dan Password Salah"
    ]);
}
?>
