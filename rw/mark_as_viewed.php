<?php
session_start();
include '../config/config.php';

if (isset($_POST['idberkassurat'])) {
    $idberkassurat = mysqli_real_escape_string($koneksi, $_POST['idberkassurat']);
    
    // Update query untuk menandai notifikasi sebagai dilihat
    $updateQuery = "UPDATE berkaspengajuansuratkeluar SET is_viewed = 1 WHERE idberkassurat = '$idberkassurat'";
    $result = mysqli_query($koneksi, $updateQuery);
    
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>