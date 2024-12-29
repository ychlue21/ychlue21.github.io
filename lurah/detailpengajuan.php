<?php
session_start(); 
include('header.php');
$iduser = $_SESSION['user_id'];
$idberkassurat = $_GET['idberkassurat'];

// Perbaiki query SQL agar lebih spesifik dan jelas
$berkas = mysqli_query($koneksi, "
   SELECT *
    FROM  berkaspengajuansuratkeluar 
    left JOIN berkaspersyaratan ON berkaspengajuansuratkeluar.idberkassurat = berkaspersyaratan.idberkassurat  
     JOIN jenissurat ON jenissurat.idJenisSurat = berkaspengajuansuratkeluar.Idjenisurat 
  left join surat_keluar on berkaspengajuansuratkeluar.idberkassurat=surat_keluar.idberkassuratkeluar
  join warga on warga.nik=berkaspengajuansuratkeluar.nik
    where berkaspengajuansuratkeluar.idberkassurat = '$idberkassurat'
");

// Ambil data
$p = mysqli_fetch_object($berkas);

// Tentukan halaman tujuan berdasarkan nilai status_rt
// $redirectUrl = (trim(strtolower($p->Status_kasi)) == 'diproses') ? 'daftarpengajuanwarga.php' : 'pengajuanwarga.php';
?>

<main class="content">
    <div class="box"
        style="width: 100%; max-width: 800px; margin: auto; font-size: 20px; border: 1px; border-radius: 8px; padding: 20px;">
        <h2 class="title text-center">Detail Pengajuan Warga</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="font-weight-bold">Jenis Surat</td>
                            <td><?= htmlspecialchars($p->jenissurat) ?></td>
                        </tr>
                        <?php if (!empty($p->tujuan)): // Cek apakah tujuan tidak kosong ?>
                        <tr>
                            <td class="font-weight-bold">Tujuan</td>
                            <td><?= htmlspecialchars($p->tujuan) ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="font-weight-bold">Nama Pengusul</td>
                            <td><?= ucwords(strtolower(htmlspecialchars($p->namalengkap))) ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">NIK</td>
                            <td><?= htmlspecialchars($p->NIK) ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tanggal Pengajuan</td>
                            <td><?= htmlspecialchars($p->tanggalpengajuan) ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Berkas Pengajuan</td>
                            <td>
                                <?php
                                // Ambil file persyaratan
                                $berkasQuery = mysqli_query($koneksi, "
                                    SELECT * 
                                    FROM berkaspersyaratan 
                                    JOIN persyaratanjenissurat ON persyaratanjenissurat.idpersyaratanberkassurat = berkaspersyaratan.idpersyaratanberkassurat 
                                    JOIN persyaratan ON persyaratan.idpersyaratan = persyaratanjenissurat.idpersyaratan
                                    WHERE berkaspersyaratan.idberkassurat = '$idberkassurat'
                                ");
                                 if (mysqli_num_rows($berkasQuery) > 0) {
            $berkasArray = [];
            while ($row = mysqli_fetch_assoc($berkasQuery)) {
                $persyaratanName = ucwords($row['persyaratan']);
                if ($row['tipe_field'] == 'text' && !empty($row['fileberkas'])) {
                    // Jika tipe_field adalah 'text', tampilkan sebagai link
                    $filePath = '../warga/persyaratan/' . $row['fileberkas'];
                    $berkasArray[] = "$persyaratanName: <a href='$filePath' target='_blank'>" . ucwords($row['fileberkas']) . "</a>";
                } elseif ($row['tipe_field'] == 'varchar' && !empty($row['fileberkas'])) {
                    // Jika tipe_field adalah 'varchar', tampilkan sebagai teks biasa
                    $berkasArray[] = "$persyaratanName: " . htmlspecialchars($row['fileberkas']);
                }elseif ($row['tipe_field'] == 'date' && !empty($row['fileberkas'])) {
                    // Jika tipe_field adalah 'varchar', tampilkan sebagai teks biasa
                    $berkasArray[] = "$persyaratanName: " . htmlspecialchars($row['fileberkas']);
                }
                 elseif ($row['tipe_field'] == 'number' && !empty($row['fileberkas'])) {
                    // Jika tipe_field adalah 'varchar', tampilkan sebagai teks biasa
                    $berkasArray[] = "$persyaratanName: " . htmlspecialchars($row['fileberkas']);
                }
            }
            if (!empty($berkasArray)) {
                echo implode('<br>', $berkasArray);
            } else {
                echo 'Tidak ada berkas persyaratan yang diunggah';
            }
        } else {
            echo 'Tidak ada berkas persyaratan yang diunggah';
        }
        ?>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td class="font-weight-bold">Berkas Pengajuan</td>
                            <td>
                                <?php
                                // Ambil file persyaratan
                                $berkasQuery = mysqli_query($koneksi, "
                                    SELECT * 
                                    FROM berkaspersyaratan 
                                    JOIN persyaratanjenissurat ON persyaratanjenissurat.idpersyaratanberkassurat = berkaspersyaratan.idpersyaratanberkassurat 
                                    JOIN persyaratan ON persyaratan.idpersyaratan = persyaratanjenissurat.idpersyaratan
                                    WHERE berkaspersyaratan.idberkassurat = '$idberkassurat'
                                ");
                                if (mysqli_num_rows($berkasQuery) > 0) {
                                    $berkasArray = [];
                                    while ($row = mysqli_fetch_assoc($berkasQuery)) {
                                        if (!empty($row['fileberkas']) && !empty($row['persyaratan'])) {
                                            $filePath = '../warga/persyaratan/' . $row['fileberkas'];
                                            $berkasArray[] = ucwords($row['persyaratan']) . ': <a href="' . $filePath . '" target="_blank">' . ucwords($row['fileberkas']) . '</a>';
                                        }
                                    }
                                    if (!empty($berkasArray)) {
                                        echo implode('<br>', $berkasArray);
                                    } else {
                                        echo 'Tidak ada berkas persyaratan yang diunggah';
                                    }
                                } else {
                                    echo 'Tidak ada berkas persyaratan yang diunggah';
                                }
                                ?>
                            </td>
                        </tr> -->
                        <tr>
                            <td class="font-weight-bold">Status RT</td>
                            <td><?= htmlspecialchars($p->status_rt) ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Status Staf Surat</td>
                            <td><?= htmlspecialchars($p->status_stafsurat) ?></td>
                        </tr>

                        <?php if (trim(strtolower($p->status_stafsurat)) == "ditolak"): ?>
                        <tr>
                            <td class="font-weight-bold">Keterangan</td>
                            <td><?= htmlspecialchars($p->keterangan) ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tanggal Selesai</td>
                            <td><?= htmlspecialchars($p->tanggalselesai) ?></td>
                        </tr>

                        <?php elseif (trim(strtolower($p->status_stafsurat)) == "disetujui"): ?>
                        <tr>
                            <td class="font-weight-bold">File Surat</td>
                            <td>
                                <?php if (!empty($p->filesurat)): ?>
                                <a href="../stafsurat/pdf_files/<?= htmlspecialchars($p->filesurat) ?>"
                                    target="_blank">Lihat
                                    Surat</a>
                                <?php else: ?>
                                <span>Tidak ada file surat</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="font-weight-bold">Status Kepala Seksi</td>
                            <td><?= htmlspecialchars($p->Status_kasi) ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Status Surat</td>
                            <td><?= htmlspecialchars($p->status_surat) ?></td>
                        </tr>

                        <?php if (trim(strtolower($p->status_surat)) == "ditolak"): ?>
                        <tr>
                            <td class="font-weight-bold">Keterangan</td>
                            <td><?= htmlspecialchars($p->keterangan) ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tanggal Selesai</td>
                            <td><?= htmlspecialchars($p->tanggalselesai) ?></td>
                        </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
            <button type="button" class="btn btn-outline-secondary mt-3"
                onclick="window.location='suratkeluar.php'">Kembali</button>
            <!-- <button type="button" class="btn btn-outline-secondary mt-3"
                onclick="window.location='<?= $redirectUrl ?>'">Kembali</button> -->
        </form>
    </div>
</main>

<?php
include('footer.php');
?>