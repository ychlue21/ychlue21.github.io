<!-- <?php
session_start();
include '../config/config.php';

if(isset($_POST['idberkassurat'])){
    $idberkassurat = $_POST['idberkassurat'];
    $updateQuery = "UPDATE berkaspengajuansuratkeluar SET is_viewed = 1 WHERE idberkassurat = '$idberkassurat'";
    mysqli_query($koneksi, $updateQuery);
}
?> -->
<?php
include '../config/config.php';

if (isset($_GET['idberkassurat'])) {
    $idberkassurat = $_GET['idberkassurat'];

    // Update is_viewed menjadi 1 untuk idberkassurat yang diklik
    $query = "UPDATE berkaspengajuansuratkeluar SET is_viewed = 1 WHERE idberkassurat = '$idberkassurat'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>