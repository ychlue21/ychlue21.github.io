<?php
// Koneksi ke database
include 'config/config.php';

// Mulai session
session_start(); // Pastikan session dimulai di awal

// Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Query untuk mengambil data pengguna dari tabel user
$sql = "SELECT * FROM user WHERE username = ?"; // Hanya ambil berdasarkan username
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Verifikasi password yang diinput dengan password yang di-hash
    if (password_verify($password, $row['password'])) {
        // Simpan data session
        $_SESSION['user_id'] = $row['id_user'];
        $_SESSION['role'] = $row['role'];

        // Cek role dan ambil jabatan jika diperlukan
        if (!in_array($row['role'], ['warga', 'rt', 'rw'])) {
            // Ambil jabatan dari tabel pegawai
            $pegawai_sql = "SELECT jabatan FROM pegawai WHERE iduser = ?";
            $pegawai_stmt = $koneksi->prepare($pegawai_sql);
            $pegawai_stmt->bind_param("i", $row['id_user']);
            $pegawai_stmt->execute();
            $pegawai_result = $pegawai_stmt->get_result();

            if ($pegawai_result->num_rows > 0) {
                $pegawai_row = $pegawai_result->fetch_assoc();
                $_SESSION['jabatan'] = $pegawai_row['jabatan']; // Simpan jabatan ke session
            } else {
                // Jika jabatan tidak ditemukan
                $_SESSION['login_failed'] = 'Jabatan tidak ditemukan';
                header('Location: index.php?login_error=true');
                exit();
            }
        }

        // Redirect ke halaman yang sesuai berdasarkan role dan jabatan
        $_SESSION['status_login'] = true; // Set status login

        switch ($row['role']) {
            case 'warga':
                header('Location: warga/index.php');
                break;
            case 'lurah':
                header('Location: lurah/index.php');
                break;
            case 'rt':
                header('Location: rt/index.php');
                break;
            case 'rw':
                header('Location: rw/index.php');
                break;
            case 'staf_surat':
                header('Location: stafsurat/index.php');
                break;
            case 'kepala_seksi':
                 if (isset($_SESSION['jabatan']) && strcasecmp($_SESSION['jabatan'], 'kepala seksi pemerintah') == 0) {
                    header('Location: kepalaseksipem/index.php');
                } else {
                    header('Location: kepalaseksi/index.php');
                }
                break;
            default:
                $_SESSION['login_failed'] = 'Role tidak dikenali';
                header('Location: index.php?login_error=true');
                exit();
        }
        exit(); // Pastikan tidak ada output setelah header
    } else {
        // Jika login gagal karena password salah
        $_SESSION['login_failed'] = 'Username atau password salah';
        header('Location: index.php?login_error=true');
        exit();
    }
} else {
    // Jika username tidak ditemukan
    $_SESSION['login_failed'] = 'Username atau password salah';
    header('Location: index.php?login_error=true');
    exit();
}
?>