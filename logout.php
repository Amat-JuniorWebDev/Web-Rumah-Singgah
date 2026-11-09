<?php
/**
 * Project: Rumah Singgah - Admin Logout
 * Lokasi: admin/logout.php
 */

session_start();

// 1. Hapus semua data yang ada di dalam variabel $_SESSION
$_SESSION = array();

// 2. Jika menggunakan cookie untuk session, hapus cookie-nya juga
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Hancurkan seluruh session yang terdaftar
session_destroy();

// 4. Arahkan kembali ke halaman login admin (satu folder)
header("Location: login.php");
exit;
?>