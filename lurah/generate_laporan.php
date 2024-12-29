<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Surat Masuk, Surat Keluar, dan Disposisi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
    /* Custom Styling */
    html,
    body {
        /* height: 100%; */
        margin: 0;
        padding: 0;
        width: 100%;
        background-color: #fff;
        font-family: 'Times New Roman', Times, serif;
        font-size: 14px;
    }

    .container {
        background-color: #fff;
        /* border-radius: 8px; */
        /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
        padding: 20px;
        margin-top: 20px;
    }

    h2 {
        color: #007bff;
        font-size: 18px;
        text-align: center;
    }

    h3,
    h4 {
        color: #343a40;
        font-size: 16px;
    }

    .table th,
    .table td {
        vertical-align: middle;
        font-size: 12px;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #dee2e6;
    }

    .table-container {
        margin-top: 20px;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f2f2f2;
    }

    .table th {
        background-color: #007bff;
        color: white;
    }

    .table td {
        background-color: #f9f9f9;
    }

    .table-container p {
        font-size: 12px;
        color: #6c757d;
    }

    .table-container .table {
        margin-bottom: 0;
    }

    .table-container h3,
    .table-container h4 {
        font-size: 15px;
    }
    </style>
</head>
<?php
// Menghubungkan ke database
include '../config/config.php'; // Pastikan Anda menyesuaikan dengan file konfigurasi koneksi DB Anda

// Menangkap bulan dan tahun yang dipilih dari form
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Query untuk mengambil data surat masuk berdasarkan bulan dan tahun yang dipilih
$querySuratMasuk = "SELECT nosuratmasuk, tanggalsurat, pengirim, tujuan
                    FROM suratmasuk 
                    WHERE MONTH(tanggalsurat) = '$bulan' AND YEAR(tanggalsurat) = '$tahun'";

// Eksekusi query untuk surat masuk
$resultSuratMasuk = mysqli_query($koneksi, $querySuratMasuk);

// Query untuk mengambil data surat keluar berdasarkan bulan dan tahun yang dipilih
$querySuratKeluar = "SELECT surat_keluar.idsuratkeluar, berkaspengajuansuratkeluar.tanggalselesai, jenissurat.jenissurat, 
                             warga.namalengkap,                
                             SUBSTRING_INDEX(SUBSTRING_INDEX(warga.alamat, 'RT ', -1), ' ', 1) AS rt,
                             SUBSTRING_INDEX(SUBSTRING_INDEX(warga.alamat, 'RW ', -1), ' ', 1) AS rw
                     FROM surat_keluar 
                     JOIN berkaspengajuansuratkeluar ON berkaspengajuansuratkeluar.idberkassurat = surat_keluar.idberkassuratkeluar 
                     JOIN jenissurat ON jenissurat.idJenisSurat = berkaspengajuansuratkeluar.Idjenisurat 
                     JOIN warga ON warga.NIK = berkaspengajuansuratkeluar.nik 
                     WHERE berkaspengajuansuratkeluar.status_surat = 'diterima' 
                     AND MONTH(berkaspengajuansuratkeluar.tanggalselesai) = '$bulan' 
                     AND YEAR(berkaspengajuansuratkeluar.tanggalselesai) = '$tahun' 
                     ORDER BY rt ASC";

// Eksekusi query untuk surat keluar
$resultSuratKeluar = mysqli_query($koneksi, $querySuratKeluar);

// Query untuk menghitung jumlah surat berdasarkan jenis surat
$queryJumlahSurat = "SELECT jenissurat.idJenisSurat, jenissurat.jenissurat, 
                            COUNT(surat_keluar.idsuratkeluar) AS jumlah_surat
                            FROM jenissurat
                            LEFT JOIN berkaspengajuansuratkeluar ON berkaspengajuansuratkeluar.Idjenisurat = jenissurat.idJenisSurat
                            LEFT JOIN surat_keluar ON surat_keluar.idberkassuratkeluar = berkaspengajuansuratkeluar.idberkassurat
                            AND MONTH(berkaspengajuansuratkeluar.tanggalselesai) = '$bulan'
                            AND YEAR(berkaspengajuansuratkeluar.tanggalselesai) = '$tahun'
                      GROUP BY jenissurat.idJenisSurat";


// Eksekusi query untuk jumlah surat
$resultJumlahSurat = mysqli_query($koneksi, $queryJumlahSurat);

// Query untuk mengambil data disposisi berdasarkan bulan dan tahun yang dipilih
$queryDisposisi = "SELECT disposisi.idDisposisi, suratmasuk.nosuratmasuk, disposisi.tanggaldisposisi, disposisi.status, pegawai.namalengkap 
                   FROM disposisi 
                   JOIN suratmasuk ON suratmasuk.nosuratmasuk = disposisi.nosurat 
                   JOIN pegawai ON pegawai.idPegawai = disposisi.idpegawai 
                   WHERE MONTH(disposisi.tanggaldisposisi) = '$bulan' 
                   AND YEAR(disposisi.tanggaldisposisi) = '$tahun' 
                   ORDER BY disposisi.tanggaldisposisi";

// Eksekusi query untuk disposisi
$resultDisposisi = mysqli_query($koneksi, $queryDisposisi);

// Query untuk menghitung total disposisi, total yang statusnya "Belum Selesai" dan "Selesai"
$queryStatus = "SELECT 
                   COUNT(*) AS total_disposisi,
                   SUM(CASE WHEN disposisi.status = 'Belum Selesai' THEN 1 ELSE 0 END) AS total_belum_selesai,
                   SUM(CASE WHEN disposisi.status = 'Selesai' THEN 1 ELSE 0 END) AS total_selesai
                FROM disposisi
                JOIN suratmasuk ON suratmasuk.nosuratmasuk = disposisi.nosurat 
                WHERE MONTH(disposisi.tanggaldisposisi) = '$bulan' 
                AND YEAR(disposisi.tanggaldisposisi) = '$tahun'";

// Eksekusi query untuk status disposisi
$resultStatus = mysqli_query($koneksi, $queryStatus);
// Memastikan nilai default adalah 0 jika tidak ada data disposisi
if ($resultStatus && mysqli_num_rows($resultStatus) > 0) {
    $status = mysqli_fetch_assoc($resultStatus);
} else {
    // Jika tidak ada disposisi, set semua status ke 0
    $status = [
        'total_disposisi' => 0,
        'total_belum_selesai' => 0,
        'total_selesai' => 0
    ];
}
?>

<body>

    <div class="container mt-4">
        <!-- <h2 class="text-center">Laporan Surat Masuk, Surat Keluar, dan Disposisi - <?php echo $bulan . '/' . $tahun; ?> -->
        </h2>
        <div class="row">
            <div class="col-12 text-center">
                <!-- Logo -->
                <img src="../assets/img/logo_kota_kupang.png" alt="Logo Kota Kupang" style="width: 100px;">
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center mt-3">
                <!-- Kop Surat -->
                <h4>PEMERINTAH KOTA KUPANG</h4>
                <h5>KECAMATAN KOTA LAMA</h5>
                <h5>KELURAHAN OEBA</h5>
                <p>JL. Beringin No. 06 Telepon (0380) 821746 Kode Pos 85226</p>
            </div>
        </div>

        <!-- Garis bawah kop surat -->
        <hr style="border-top: 2px solid black;">

        <div class="row">
            <div class="col-12 text-center mt-4">
                <!-- Judul Surat -->
                <h4><strong>Laporan Surat Masuk, Surat Keluar, dan Disposisi</strong></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center mt-2">
                <!-- Nomor Surat -->
                <p>Bulan: <?php echo $bulan . '/' . $tahun; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-container">
                    <h3>Surat Masuk</h3>
                    <?php if ($resultSuratMasuk && mysqli_num_rows($resultSuratMasuk) > 0) { ?>
                    <p>Jumlah Surat Masuk: <?php echo mysqli_num_rows($resultSuratMasuk); ?></p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No Surat Masuk</th>
                                <th>Tanggal Surat</th>
                                <th>Pengirim</th>
                                <th>Tujuan</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($resultSuratMasuk)) { ?>
                            <tr>
                                <td><?php echo $row['nosuratmasuk']; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row['tanggalsurat'])); ?></td>
                                <td><?php echo $row['pengirim']; ?></td>
                                <td><?php echo $row['tujuan']; ?></td>

                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php } else { ?>
                    <p>Tidak ada surat masuk untuk periode ini.</p>
                    <?php } ?>
                </div>

                <!-- Surat Keluar Section -->
                <div class="table-container">
                    <h3>Surat Keluar</h3>
                    <?php if ($resultSuratKeluar && mysqli_num_rows($resultSuratKeluar) > 0) { ?>
                    <p>Jumlah Surat Keluar: <?php echo mysqli_num_rows($resultSuratKeluar); ?></p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No Surat Keluar</th>
                                <th>Jenis Surat</th>
                                <th>Nama Warga</th>
                                <th>RT/RW</th>
                                <th>Tanggal Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($resultSuratKeluar)) { ?>
                            <tr>
                                <td><?php echo $row['idsuratkeluar']; ?></td>
                                <td><?php echo $row['jenissurat']; ?></td>
                                <td><?php echo $row['namalengkap']; ?></td>
                                <td><?php echo $row['rt'] . '/' . $row['rw']; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row['tanggalselesai'])); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php } else { ?>
                    <p>Tidak ada surat keluar untuk periode ini.</p>
                    <?php } ?>
                </div>

                <!-- Jumlah Surat Berdasarkan Jenis Surat -->
                <div class="table-container">
                    <h3>Jumlah Surat Berdasarkan Jenis Surat</h3>
                    <?php if ($resultJumlahSurat && mysqli_num_rows($resultJumlahSurat) > 0) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Jenis Surat</th>
                                <th>Jumlah Surat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($resultJumlahSurat)) { ?>
                            <tr>
                                <td><?php echo $row['jenissurat']; ?></td>
                                <td><?php echo $row['jumlah_surat'] > 0 ? $row['jumlah_surat'] : 0; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php } else { ?>
                    <p>Tidak ada data jumlah surat untuk periode ini.</p>
                    <?php } ?>
                </div>

                <!-- Disposisi Section -->
                <div class="table-container">
                    <h3>Disposisi</h3>
                    <?php if ($resultDisposisi && mysqli_num_rows($resultDisposisi) > 0) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No Surat Masuk</th>
                                <th>Tanggal Disposisi</th>
                                <th>Status</th>
                                <th>Nama Pegawai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($resultDisposisi)) { ?>
                            <tr>
                                <td><?php echo $row['nosuratmasuk']; ?></td>
                                <td><?php echo $row['tanggaldisposisi']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td><?php echo $row['namalengkap']; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php } else { ?>
                    <p>Tidak ada disposisi untuk periode ini.</p>
                    <?php } ?>
                </div>

                <!-- Total Disposisi -->
                <!-- <div class="table-container">
            <h4>Total Disposisi</h4>
            <p>Total Disposisi: <?php echo $status['total_disposisi']; ?></p>
            <p>Disposisi Belum Selesai: <?php echo $status['total_belum_selesai']; ?></p>
            <p>Disposisi Selesai: <?php echo $status['total_selesai']; ?></p>
        </div> -->
                <div class="table-container mt-4">
                    <h4>Total Disposisi</h4>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Disposisi</td>
                                <td><?php echo $status['total_disposisi']; ?></td>
                            </tr>
                            <tr>
                                <td>Disposisi Belum Selesai</td>
                                <td><?php echo $status['total_belum_selesai']; ?></td>
                            </tr>
                            <tr>
                                <td>Disposisi Selesai</td>
                                <td><?php echo $status['total_selesai']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>


    </div>

</body>

</html>