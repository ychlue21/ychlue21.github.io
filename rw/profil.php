<?php
include('header.php');
?>
<?php
$iduser = $_SESSION['user_id'];
$rw=mysqli_query($koneksi,"SELECT * from ketua_Rw join warga on ketua_rw.nik=warga.nik join user on user.id_user=ketua_rw.iduser WHERE id_user = '$iduser'");
$p=mysqli_fetch_object($rw);
?>
<main class="content">
    <h2 class="title text-center mb-4">Profil</h2>
    <div class="box" style="max-width: 800px; margin: auto;">
        <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-12 mb-3">
            </div>
            <!-- Row Pertama -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="NIK" class="form-label">NIK</label>
                    <input type="text" name="NIK" id="NIK" class="form-control" value="<?php echo $p->NIK; ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="NOKK" class="form-label">NO KK</label>
                    <input type="text" name="NOKK" id="NOKK" class="form-control" value="<?php echo $p->NOKK; ?>"
                        required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="namalengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" name="namalengkap" id="namalengkap" class="form-control"
                        value="<?php echo $p->namalengkap; ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="JK" class="form-label">Jenis Kelamin</label>
                    <select name="JK" class="form-select" required>
                        <option value="">--- Pilih ---</option>
                        <option value="Perempuan" <?=($p->JK=='Perempuan')?'selected':'';?>>Perempuan</option>
                        <option value="Laki-laki" <?=($p->JK=='Laki-laki')?'selected':'';?>>Laki-laki</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                        value="<?= $p->tempat_lahir; ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="tgl_Lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tgl_Lahir" id="tgl_Lahir" class="form-control"
                        value="<?= $p->tgl_Lahir; ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="agama" class="form-label">Agama</label>
                    <select name="agama" id="agama" class="form-select" required>
                        <option value="">--- Pilih ---</option>
                        <option value="Kristen Protestan" <?= ($p->agama == 'Kristen Protestan') ? 'selected' : ''; ?>>
                            Kristen Protestan</option>
                        <option value="Katolik" <?= ($p->agama == 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                        <option value="Islam" <?= ($p->agama == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                        <option value="Hindu" <?= ($p->agama == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                        <option value="Buddha" <?= ($p->agama == 'Buddha') ? 'selected' : ''; ?>>Buddha</option>
                        <option value="Konghucu" <?= ($p->agama == 'Konghucu') ? 'selected' : ''; ?>>Konghucu</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" value="<?= $p->alamat; ?>"
                        required>
                </div>
            </div>
            <div class="row mb-3">

                <div class="col-md-6">
                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" class="form-control"
                        value="<?= $p->pekerjaan; ?>" required>
                </div>
            </div>

            <div class="col-12 mb-3">
                <h5>Akun Pengguna</h5>
            </div>
            <!-- Row Kedua -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= $p->username; ?>"
                        required>
                </div>
                <div class="col-md-6">
                    <label for="old_password" class="form-label">Password Lama</label>
                    <div class="input-group">
                        <input type="password" name="old_password" id="old_password" class="form-control" required>
                        <span class="input-group-text" id="toggleOldPassword">
                            <i class="bi bi-eye-slash" id="eyeOldPassword"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="new_password" class="form-label">Password Baru</label>
                    <div class="input-group">
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                        <span class="input-group-text" id="toggleNewPassword">
                            <i class="bi bi-eye-slash" id="eyeNewPassword"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                            required>
                        <span class="input-group-text" id="toggleConfirmPassword">
                            <i class="bi bi-eye-slash" id="eyeConfirmPassword"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-outline-secondary"
                    onclick="window.location='index.php'">Kembali</button>
                <button type="submit" name="submit" class="btn btn-outline-success">Ubah</button>
            </div>
        </form>
        <script>
        // Fungsi untuk men-toggle tipe input password
        function togglePassword(inputId, eyeId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(eyeId);

            if (input.type === "password") {
                input.type = "text";
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            } else {
                input.type = "password";
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            }
        }

        // Event listener untuk masing-masing ikon
        document.getElementById('toggleOldPassword').addEventListener('click', function() {
            togglePassword('old_password', 'eyeOldPassword');
        });

        document.getElementById('toggleNewPassword').addEventListener('click', function() {
            togglePassword('new_password', 'eyeNewPassword');
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            togglePassword('confirm_password', 'eyeConfirmPassword');
        });
        </script>

        <?php
if (isset($_POST['submit'])) {   
    $iduser = $_SESSION['user_id'];
    $NIK = $_POST['NIK'];
    $NOKK = $_POST['NOKK'];
    $namalengkap = ucwords($_POST['namalengkap']);
    $JK = $_POST['JK'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_Lahir = $_POST['tgl_Lahir'];
    $agama = $_POST['agama'];
    $alamat = ucwords($_POST['alamat']);  
    $pekerjaan = $_POST['pekerjaan'];
    $username = $_POST['username'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $queryPassword = mysqli_query($koneksi, "SELECT password FROM user WHERE id_user = '$iduser'");

    if (!$queryPassword) {
        die("Query error: " . mysqli_error($koneksi));
    }

    $userData = mysqli_fetch_object($queryPassword);

    if (!$userData) {
        echo 'User tidak ditemukan.';
    } else {
        // Verifikasi password lama menggunakan hashing
        if (password_verify($old_password, $userData->password)) {
            $updateQuery = "UPDATE warga SET 
                                NIK='$NIK',
                                NOKK='$NOKK',
                                namalengkap='$namalengkap',
                                JK='$JK',
                                tempat_lahir='$tempat_lahir',
                                tgl_Lahir='$tgl_Lahir',
                                agama='$agama',
                                alamat='$alamat',
                                pekerjaan='$pekerjaan'
                            WHERE NIK='" . $_GET['NIK'] . "'";
            $updateWarga = mysqli_query($koneksi, $updateQuery);

            if (!empty($new_password) && $new_password === $confirm_password) {
                // Hash password baru sebelum menyimpannya
                $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
                $updateUser = mysqli_query($koneksi, "UPDATE user SET username='$username', password='$hashedPassword' WHERE id_user='$iduser'");
            } else {
                echo 'Password baru dan konfirmasi tidak cocok.';
            }

            if ($updateWarga && (!empty($new_password) ? $updateUser : true)) {
                echo '<script>window.location="index.php";</script>';
            } else {
                echo 'Data gagal diperbarui: ' . mysqli_error($koneksi);
            }
        } else {
            echo 'Password lama tidak sesuai.';
        }
    }
}

?>
    </div>

</main>
<?php
include('footer.php');
?>