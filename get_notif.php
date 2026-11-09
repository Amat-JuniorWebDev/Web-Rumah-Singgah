<?php
// get_notif.php
// Pastikan path ke config.php sudah benar sesuai folder kamu
include 'user/config.php';

// Atur agar outputnya berupa JSON (standar API)
header('Content-Type: application/json');

// Ambil 1 notifikasi terbaru dengan ID paling besar
$query = "SELECT id, pesan FROM notifikasi ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    
    // Kirim data dalam format JSON
    echo json_encode([
        'id' => (int)$data['id'],
        'pesan' => $data['pesan']
    ]);
} else {
    // Jika belum ada notifikasi sama sekali di database
    echo json_encode([
        'id' => 0,
        'pesan' => ''
    ]);
}

mysqli_close($conn);
?>