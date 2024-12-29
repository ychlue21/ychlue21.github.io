<?php
include('header.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}
$iduser= $_SESSION['user_id'];
$pegawai = mysqli_query($koneksi, "SELECT * from pegawai join user on user.id_user=pegawai.iduser WHERE iduser = '$iduser'");
$p = mysqli_fetch_object($pegawai);

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
                    <label for="idPegawai" class="form-label">NIP</label>
                    <input type="idPegawai" name="idPegawai" id="idPegawai" class="form-control"
                        value="<?php echo $p->idPegawai; ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="namalengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" name="namalengkap" id="namalengkap" class="form-control"
                        value="<?php echo $p->namalengkap; ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="JK" class="form-label">Jenis Kelamin</label>
                    <select name="JK" class="form-select" required>
                        <option value="">--- Pilih ---</option>
                        <option value="Perempuan" <?=($p->JK=='Perempuan')?'selected':'';?>>Perempuan</option>
                        <option value="Laki-laki" <?=($p->JK=='Laki-laki')?'selected':'';?>>Laki-laki</option>
                    </select>
                </div>
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
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="Tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" name="Tempat_lahir" id="Tempat_lahir" class="form-control"
                        value="<?= $p->Tempat_lahir; ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="Tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="Tanggal_lahir" id="Tanggal_lahir" class="form-control"
                        value="<?= $p->Tanggal_lahir; ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" value="<?= $p->alamat; ?>"
                        required>
                </div>
                <div class="col-md-6">
                    <label for="jabatan" class="form-label">Pekerjaan</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control" value="<?= $p->jabatan; ?>"
                        required>
                </div>
            </div>
            <div class="row mb-3">

                <div class="col-md-6">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= $p->no_hp; ?>" required>
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
                        <input type="password" name="old_password" id="old_password" class="form-control">
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
                        <input type="password" name="new_password" id="new_password" class="form-control">
                        <span class="input-group-text" id="toggleNewPassword">
                            <i class="bi bi-eye-slash" id="eyeNewPassword"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control">
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
            // Ambil data dari form
            $iduser = $_SESSION['user_id'];
            $idPegawai = $_POST['idPegawai'];
            $namalengkap = ucwords($_POST['namalengkap']);
            $JK = $_POST['JK'];
            $Tempat_lahir = $_POST['Tempat_lahir'];
            $Tanggal_lahir = $_POST['Tanggal_lahir'];
            $agama = $_POST['agama'];
            $alamat = ucwords($_POST['alamat']);  
            $no_hp = $_POST['no_hp'];
            $jabatan = $_POST['jabatan'];
            $username = $_POST['username'];
            $old_password = $_POST['old_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            // Query untuk memperbarui data warga
                    $updateQuery = "UPDATE pegawai SET 
                                    idPegawai='$idPegawai',
                                    namalengkap='$namalengkap',
                                    JK='$JK',
                                    Tempat_lahir='$Tempat_lahir',
                                    Tanggal_lahir='$Tanggal_lahir',
                                    agama='$agama',
                                    alamat='$alamat',
                                    jabatan='$jabatan',
                                    no_hp='$no_hp'
                                   WHERE iduser='$iduser'";

                    $updateWarga = mysqli_query($koneksi, $updateQuery);

                   $passwordUpdateQuery = "UPDATE user SET username='$username'";

    // Jika password lama diisi, cek kesesuaian dan update password baru jika konfirmasi cocok
    if (!empty($old_password)) {
        $queryPassword = mysqli_query($koneksi, "SELECT password FROM user WHERE id_user = '$iduser'");
        $userData = mysqli_fetch_object($queryPassword);

        if ($userData && password_verify($old_password, $userData->password)) {
            // Jika password baru dan konfirmasi diisi dan cocok, update password
            if (!empty($new_password) && $new_password === $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $passwordUpdateQuery .= ", password='$hashed_password'";
            } elseif (!empty($new_password) || !empty($confirm_password)) {
                // Jika hanya salah satu dari password baru atau konfirmasi yang kosong, tampilkan error
                echo 'Konfirmasi password baru tidak sesuai.';
                exit;
            }
        } else {
            echo 'Password lama tidak sesuai.';
            exit;
        }
    }

    // Eksekusi query update username dan password (jika ada)
    $passwordUpdateQuery .= " WHERE id_user='$iduser'";
    $updateUser = mysqli_query($koneksi, $passwordUpdateQuery);

    // Cek apakah update berhasil
    if ($updateWarga && $updateUser) {
        echo '<script>window.location="index.php";</script>';
    } else {
        echo 'Data gagal diperbarui: ' . mysqli_error($koneksi);
    }
}
?>
    </div>
</main>
<?php
include('footer.php');
?>