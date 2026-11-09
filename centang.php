<?php
include 'user/config.php'; // Sesuaikan path config-mu

if (isset($_POST['update_id'])) {
    $id = $_POST['update_id'];
    $status = $_POST['new_status'];

    $query = mysqli_query($conn, "UPDATE izin_keluar SET status = '$status' WHERE id = '$id'");
    
    if ($query) {
        echo "success";
    } else {
        echo "error";
    }
}
?>