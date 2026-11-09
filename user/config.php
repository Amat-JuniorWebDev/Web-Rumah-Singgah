<?php
/**
 * DATABASE CONFIGURATION - RUMAH SINGGAH
 * Developer: Rahmat
 */

// 1. Matikan error reporting yang mengganggu tampilan UI
// Tapi tetap simpan error-nya di variabel agar bisa kita panggil
error_reporting(0); 

$db_host = "localhost:3306"; 
$db_user = "root";      
$db_pass = "";          
$db_name = "dbrumah_singgah"; 

// 2. Mencoba koneksi
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// 3. Cek Koneksi secara halus
// Kita tidak pakai die() agar menu.php tetap bisa tampil
if (!$conn) {
    // Simpan pesan error ke dalam variabel global agar bisa dibaca di menu.php
    $GLOBALS['db_error'] = mysqli_connect_error();
    $conn = false; 
} else {
    // Jika koneksi sukses, set charset agar aman
    mysqli_set_charset($conn, "utf8mb4");
    $GLOBALS['db_error'] = "";
}
?>