<?php
require('../library/fpdf/fpdf.php');
include '../config/config.php'; // Sesuaikan dengan file konfigurasi DB Anda

// Array nama bulan dalam format huruf
$bulanArray = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
];


// Menangkap bulan dan tahun dari URL atau default saat ini
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Mengubah bulan menjadi nama bulan dalam huruf
$bulanNama = $bulanArray[$bulan];

// Query data surat masuk
$querySuratMasuk = "SELECT nosuratmasuk, tanggalsurat, pengirim, tujuan FROM suratmasuk WHERE MONTH(tanggalsurat) = '$bulan' AND YEAR(tanggalsurat) = '$tahun'";
$resultSuratMasuk = mysqli_query($koneksi, $querySuratMasuk);

// Query data surat keluar
$querySuratKeluar = "SELECT surat_keluar.idsuratkeluar, berkaspengajuansuratkeluar.tanggalselesai, jenissurat.jenissurat, warga.namalengkap, 
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
$resultSuratKeluar = mysqli_query($koneksi, $querySuratKeluar);

// Query jumlah surat berdasarkan jenis surat
$queryJumlahSurat = "SELECT jenissurat.idJenisSurat, jenissurat.jenissurat, 
                            COUNT(surat_keluar.idsuratkeluar) AS jumlah_surat
                            FROM jenissurat
                            LEFT JOIN berkaspengajuansuratkeluar ON berkaspengajuansuratkeluar.Idjenisurat = jenissurat.idJenisSurat
                            LEFT JOIN surat_keluar ON surat_keluar.idberkassuratkeluar = berkaspengajuansuratkeluar.idberkassurat
                            AND MONTH(berkaspengajuansuratkeluar.tanggalselesai) = '$bulan'
                            AND YEAR(berkaspengajuansuratkeluar.tanggalselesai) = '$tahun'
                      GROUP BY jenissurat.idJenisSurat";
$resultJumlahSurat = mysqli_query($koneksi, $queryJumlahSurat);

// Query jumlah surat berdasarkan rt
$querySuratkeluarRT="SELECT rt.idrt,rt.NAMA_RT,warga.namalengkap as ketua_rt, COUNT(surat_keluar.idsuratkeluar) AS jumlah_surat
                            FROM jenissurat
                            LEFT JOIN berkaspengajuansuratkeluar ON berkaspengajuansuratkeluar.Idjenisurat = jenissurat.idJenisSurat
                            LEFT JOIN surat_keluar ON surat_keluar.idberkassuratkeluar = berkaspengajuansuratkeluar.idberkassurat
                            AND MONTH(berkaspengajuansuratkeluar.tanggalselesai) = '$bulan'
                            AND YEAR(berkaspengajuansuratkeluar.tanggalselesai) = '$tahun'
                            join ketua_rt on ketua_rt.IDKETUART=berkaspengajuansuratkeluar.idRT
                            join rt on ketua_rt.IDRT=rt.IDRT
                            join warga on warga.NIK=ketua_rt.NIK
                      GROUP BY rt.nama_rt";
$resultSuratkeluarRT = mysqli_query($koneksi, $querySuratkeluarRT);

// Query data disposisi
$queryDisposisi = "SELECT disposisi.idDisposisi, suratmasuk.nosuratmasuk, disposisi.tanggaldisposisi, disposisi.status, pegawai.namalengkap 
                   FROM disposisi 
                   JOIN suratmasuk ON suratmasuk.nosuratmasuk = disposisi.nosurat 
                   JOIN pegawai ON pegawai.idPegawai = disposisi.idpegawai 
                   WHERE MONTH(disposisi.tanggaldisposisi) = '$bulan' 
                   AND YEAR(disposisi.tanggaldisposisi) = '$tahun' 
                   ORDER BY disposisi.tanggaldisposisi";
$resultDisposisi = mysqli_query($koneksi, $queryDisposisi);

// Query total status disposisi
$queryStatus = "SELECT 
                   COUNT(*) AS total_disposisi,
                   SUM(CASE WHEN disposisi.status = 'Belum Selesai' THEN 1 ELSE 0 END) AS total_belum_selesai,
                   SUM(CASE WHEN disposisi.status = 'Selesai' THEN 1 ELSE 0 END) AS total_selesai
                FROM disposisi
                JOIN suratmasuk ON suratmasuk.nosuratmasuk = disposisi.nosurat 
                WHERE MONTH(disposisi.tanggaldisposisi) = '$bulan' 
                AND YEAR(disposisi.tanggaldisposisi) = '$tahun'";
$resultStatus = mysqli_query($koneksi, $queryStatus);
$status = mysqli_fetch_assoc($resultStatus) ?: ['total_disposisi' => 0, 'total_belum_selesai' => 0, 'total_selesai' => 0];

// class PDF extends FPDF {
//     // Header function untuk menampilkan header pada setiap halaman
//     function Header() {
//         // Logo
//         $this->Image('../assets/img/logo_kota_kupang.png', 10, 10, 20); // Logo diatur ke lebar 20 agar lebih proporsional
//         // Set font untuk judul
//         $this->SetFont('Times', 'B', 12);
//         $this->Cell(0, 7, 'PEMERINTAH KOTA KUPANG', 0, 1, 'C');
//         $this->Cell(0, 7, 'KECAMATAN KOTA LAMA', 0, 1, 'C');

//         $this->SetFont('Times', 'B', 14);
//         $this->Cell(0, 7, 'KELURAHAN OEBA', 0, 1, 'C');

//         $this->SetFont('Times', '', 10);
//         $this->Cell(0, 7, 'JL. Beringin No. 06 Telepon (0380) 821746 Kode Pos 85226', 0, 1, 'C');

//         // Tambahkan garis di bawah kop surat
//         $this->SetLineWidth(0.5);
//         $this->Line(10, 40, 200, 40); // Garis tebal utama
//         $this->SetLineWidth(0.2);
//         $this->Line(10, 42, 200, 42); // Garis tipis di bawahnya

//         $this->Ln(10); // Memberikan jarak sebelum konten selanjutnya
//     }

//     // Footer function untuk menampilkan footer pada setiap halaman 
//     function Footer() {
//     // Posisikan footer 15mm dari bawah
//     $this->SetY(-15); 
//     $this->SetFont('Arial', 'I', 8);
//     $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
// }
// }

        $pdf = new FPDF('P', 'mm', [210, 330]);
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);
        
$pdf->Image('../assets/img/logo_kota_kupang.png', 10, 10, 20); // Logo diatur ke lebar 20 agar lebih proporsional

// Atur font Tahoma untuk judul dan kop surat
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 7, 'PEMERINTAH KOTA KUPANG', 0, 1, 'C');
$pdf->Cell(0, 7, 'KECAMATAN KOTA LAMA', 0, 1, 'C');

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 7, 'KELURAHAN OEBA', 0, 1, 'C');

$pdf->SetFont('Times', '', 10);
$pdf->Cell(0, 7, 'JL. Beringin No. 06 Telepon (0380) 821746 Kode Pos 85226', 0, 1, 'C');

// Tambahkan garis di bawah kop surat
$pdf->SetLineWidth(0.5);
$pdf->Line(10, 40, 200, 40); // Garis tebal utama
$pdf->SetLineWidth(0.2);
$pdf->Line(10, 42, 200, 42); // Garis tipis di bawahnya

$pdf->Ln(10); // Memberikan jarak sebelum konten selanjutnya
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Laporan Surat Masuk, Surat Keluar, dan Disposisi', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Bulan: $bulanNama $tahun", 0, 1, 'C');
$pdf->Ln(5);



// Bagian Surat Masuk
// Atur font dan latar belakang untuk judul bagian
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(100, 150, 255); // Warna latar belakang biru muda lebih gelap untuk header
$pdf->Cell(0, 10, 'Surat Masuk', 0, 1);
// $pdf->Ln(5); // Jarak antara judul dan isi

// Mengecek apakah ada data surat masuk
if ($resultSuratMasuk && mysqli_num_rows($resultSuratMasuk) > 0) {
    // Menampilkan jumlah surat masuk
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'Jumlah Surat Masuk: ' . mysqli_num_rows($resultSuratMasuk), 0, 1);
    
    // Membuat header tabel dengan warna latar belakang
    $pdf->SetFont('Arial', 'B', 10);
    // $pdf->SetFillColor(200, 200, 255); // Warna latar belakang header tabel
    $pdf->SetFillColor(100, 150, 255); // Warna latar belakang header tabel
    $pdf->Cell(40, 10, 'No Surat Masuk', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Tanggal Surat', 1, 0, 'C', true);
    $pdf->Cell(60, 10, 'Pengirim', 1, 0, 'C', true);
    $pdf->Cell(50, 10, 'Tujuan', 1, 1, 'C', true);

    // Menambahkan data surat masuk ke dalam tabel
    $pdf->SetFont('Arial', '', 10); // Kembali ke font reguler untuk isi tabel
    while ($row = mysqli_fetch_assoc($resultSuratMasuk)) {
        $pdf->Cell(40, 10, $row['nosuratmasuk'], 1);
        $pdf->Cell(40, 10, date('d-m-Y', strtotime($row['tanggalsurat'])), 1);
        $pdf->Cell(60, 10, $row['pengirim'], 1);
        $pdf->Cell(50, 10, $row['tujuan'], 1);
        $pdf->Ln(); // Baris baru untuk setiap entri
    }
} else {
    // Menampilkan pesan jika tidak ada surat masuk
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Tidak ada surat masuk untuk periode ini.', 0, 1, 'C');
}
$pdf->Ln(5); // Jarak tambahan setelah tabel atau pesan



// // Bagian Surat Keluar
// // Menentukan font dan menampilkan judul bagian "Surat Keluar"
// $pdf->SetFont('Arial', 'B', 12);
// $pdf->Cell(0, 10, 'Surat Keluar', 0, 1);
// $pdf->Ln(5); // Jarak antara judul dan isi

// // Mengecek apakah ada data surat keluar
// if ($resultSuratKeluar && mysqli_num_rows($resultSuratKeluar) > 0) {
//     // Menampilkan jumlah surat keluar
//     $pdf->SetFont('Arial', '', 10);
//     $pdf->Cell(0, 10, 'Jumlah Surat Keluar: ' . mysqli_num_rows($resultSuratKeluar), 0, 1);
    
//     // Membuat header tabel dengan warna latar belakang
//     $pdf->SetFont('Arial', 'B', 10);
//     $pdf->SetFillColor(100, 150, 255); // Warna latar belakang header tabel
//     $pdf->Cell(40, 10, 'No Surat Keluar', 1, 0, 'C', true);
//     $pdf->Cell(50, 10, 'Jenis Surat', 1, 0, 'C', true);
//     $pdf->Cell(40, 10, 'Nama Warga', 1, 0, 'C', true);
//     $pdf->Cell(20, 10, 'RT/RW', 1, 0, 'C', true);
//     $pdf->Cell(40, 10, 'Tanggal Selesai', 1, 1, 'C', true);

//     // Mengisi data tabel surat keluar
//     $pdf->SetFont('Arial', '', 10); // Mengembalikan font ke reguler untuk isi tabel
//     while ($row = mysqli_fetch_assoc($resultSuratKeluar)) {
//         $pdf->Cell(40, 10, $row['idsuratkeluar'], 1);
//         $pdf->Cell(50, 10, $row['jenissurat'], 1);
//         $pdf->Cell(40, 10, $row['namalengkap'], 1);
//         $pdf->Cell(20, 10, $row['rt'] . '/' . $row['rw'], 1);
//         $pdf->Cell(40, 10, date('d-m-Y', strtotime($row['tanggalselesai'])), 1);
//         $pdf->Ln();
//     }
// } else {
//     // Menampilkan pesan jika tidak ada surat keluar
//     $pdf->SetFont('Arial', 'I', 10);
//     $pdf->Cell(0, 10, 'Tidak ada surat keluar untuk periode ini.', 0, 1, 'C');
// }
// $pdf->Ln(5); // Jarak tambahan setelah tabel atau pesan

// Bagian Surat Keluar
// Menentukan font dan menampilkan judul bagian "Surat Keluar"
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Surat Keluar', 0, 1);
// $pdf->Ln(5); // Jarak antara judul dan isi

// Mengecek apakah ada data surat keluar
if ($resultSuratKeluar && mysqli_num_rows($resultSuratKeluar) > 0) {
    // Menampilkan jumlah surat keluar
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'Jumlah Surat Keluar: ' . mysqli_num_rows($resultSuratKeluar), 0, 1);
    
    // Membuat header tabel dengan warna latar belakang
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(100, 150, 255); // Warna latar belakang header tabel
    $pdf->Cell(40, 10, 'No Surat Keluar', 1, 0, 'C', true);
    $pdf->Cell(60, 10, 'Jenis Surat', 1, 0, 'C', true); // Memperbesar lebar kolom
    $pdf->Cell(40, 10, 'Nama Warga', 1, 0, 'C', true);
    $pdf->Cell(20, 10, 'RT/RW', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Tanggal Selesai', 1, 1, 'C', true);

    // Mengisi data tabel surat keluar
    $pdf->SetFont('Arial', '', 10); // Mengembalikan font ke reguler untuk isi tabel
    while ($row = mysqli_fetch_assoc($resultSuratKeluar)) {
        $pdf->Cell(40, 10, $row['idsuratkeluar'], 1);
        $pdf->Cell(60, 10, $row['jenissurat'], 1); // Memperbesar lebar kolom
        $pdf->Cell(40, 10, $row['namalengkap'], 1);
        $pdf->Cell(20, 10, $row['rt'] . '/' . $row['rw'], 1);
        $pdf->Cell(30, 10, date('d-m-Y', strtotime($row['tanggalselesai'])), 1);
        $pdf->Ln();
    }
} else {
    // Menampilkan pesan jika tidak ada surat keluar
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Tidak ada surat keluar untuk periode ini.', 0, 1, 'C');
}
$pdf->Ln(5); // Jarak tambahan setelah tabel atau pesan


// Bagian Jumlah Surat Berdasarkan Jenis Surat
$pdf->SetFont('Arial', 'B', 12);
// $pdf->SetFillColor(200, 220, 255); // Warna latar belakang biru muda untuk header
$pdf->Cell(0, 10, 'Jumlah Surat Berdasarkan Jenis Surat', 0, 1);
$pdf->SetFont('Arial', '', 10);
// Tentukan total lebar tabel
$totalWidth = 190; // Lebar tabel (dalam mm), disesuaikan dengan lebar halaman

// Tentukan lebar kolom berdasarkan total lebar
$jenisSuratWidth = 140; // Lebar kolom Jenis Surat
$jumlahSuratWidth = 50; // Lebar kolom Jumlah Surat

if (mysqli_num_rows($resultJumlahSurat) > 0) {
    // Header tabel
    $pdf->SetFillColor(100, 150, 255); // Warna latar belakang header tabel
    $pdf->Cell($jenisSuratWidth, 10, 'Jenis Surat', 1, 0, 'C',true);
    $pdf->Cell($jumlahSuratWidth, 10, 'Jumlah Surat', 1, 1, 'C',true);
    
    // Data tabel
    while ($row = mysqli_fetch_assoc($resultJumlahSurat)) {
        $pdf->Cell($jenisSuratWidth, 10, $row['jenissurat'], 1);
        $pdf->Cell($jumlahSuratWidth, 10, $row['jumlah_surat'], 1);
        $pdf->Ln();
        
    }
} else {
    $pdf->Cell(0, 10, 'Tidak ada data jumlah surat untuk periode ini.', 0, 1);
}
 $pdf->Ln(5);

 // Bagian surat keluar berdasarkan RT
// Atur font dan latar belakang untuk judul bagian
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(100, 150, 255); // Warna latar belakang biru muda lebih gelap untuk header
$pdf->Cell(0, 10, 'Jumlah Surat Berdasarkan RT', 0, 1);
// $pdf->Cell(0, 10, 'Jumlah Surat Berdasarkan RT', 0, 1, 'C', true);
// $pdf->Ln(5); // Jarak antara judul dan isi

// Mengecek apakah ada data surat keluar
if ($resultSuratkeluarRT && mysqli_num_rows($resultSuratkeluarRT) > 0) {
    // Menampilkan jumlah surat keluar
    $pdf->SetFont('Arial', '', 10);
    
    // Membuat header tabel dengan warna latar belakang
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(100, 150, 255); // Warna latar belakang header tabel
    $pdf->Cell(50, 10, 'RT', 1, 0, 'C', true);
    $pdf->Cell(80, 10, 'Nama Ketua RT', 1, 0, 'C', true);
    $pdf->Cell(60, 10, 'Jumlah Surat', 1, 0, 'C', true);
    $pdf->Ln(); // Baris baru untuk header tabel

    // Menambahkan data surat keluar ke dalam tabel
    $pdf->SetFont('Arial', '', 10); // Kembali ke font reguler untuk isi tabel
    while ($row = mysqli_fetch_assoc($resultSuratkeluarRT)) {
        $pdf->Cell(50, 10, $row['NAMA_RT'], 1);
        $pdf->Cell(80, 10, $row['ketua_rt'], 1);
        $pdf->Cell(60, 10, $row['jumlah_surat'], 1);
        $pdf->Ln(); // Baris baru untuk setiap entri
    }
} else {
    // Menampilkan pesan jika tidak ada surat keluar
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Tidak ada surat keluar untuk periode ini.', 0, 1, 'C');
}
$pdf->Ln(5); // Jarak setelah tabel
//  // Bagian Surat Masuk
// // Atur font dan latar belakang untuk judul bagian
// $pdf->SetFont('Arial', 'B', 12);
// $pdf->SetFillColor(100, 150, 255); // Warna latar belakang biru muda lebih gelap untuk header
// $pdf->Cell(0, 10, 'Jumlah Surat Berdasarkan RT', 0, 1);
// $pdf->Ln(5); // Jarak antara judul dan isi

// // Mengecek apakah ada data surat masuk
// if ($resultSuratMasuk && mysqli_num_rows($resultSuratMasuk) > 0) {
//     // Menampilkan jumlah surat masuk
//     $pdf->SetFont('Arial', '', 10);
    
//     // Membuat header tabel dengan warna latar belakang
//     $pdf->SetFont('Arial', 'B', 10);
//     $pdf->SetFillColor(100, 150, 255); // Warna latar belakang header tabel
//     $pdf->Cell(40, 10, 'RT', 1, 0, 'C', true);
//     $pdf->Cell(40, 10, 'Nama Ketua RT', 1, 0, 'C', true);
//     $pdf->Cell(60, 10, 'Jumlah Surat', 1, 0, 'C', true);
  

//     // Menambahkan data surat masuk ke dalam tabel
//     $pdf->SetFont('Arial', '', 10); // Kembali ke font reguler untuk isi tabel
//     while ($row = mysqli_fetch_assoc($resultSuratMasuk)) {
//         $pdf->Cell(40, 10, $row['NAMA_RT'], 1);
//         $pdf->Cell(60, 10, $row['namalengkap'], 1);
//         $pdf->Cell(50, 10, $row['jumlah_surat'], 1);
//         $pdf->Ln(); // Baris baru untuk setiap entri
//     }
// } else {
//     // Menampilkan pesan jika tidak ada surat masuk
//     $pdf->SetFont('Arial', 'I', 10);
//     $pdf->Cell(0, 10, 'Tidak ada surat masuk untuk periode ini.', 0, 1, 'C');
// }
// $pdf->Ln(5); // Jarak tambahan setelah tabel atau pesan

// Bagian Disposisi
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Disposisi', 0, 1);
$pdf->SetFont('Arial', '', 10);
// Menetapkan warna latar belakang header tabel (misalnya biru muda)
$pdf->SetFillColor(100, 150, 255); // Warna latar belakang biru muda

if (mysqli_num_rows($resultDisposisi) > 0) {
    // Membuat header tabel dengan warna latar belakang
    $pdf->Cell(30, 10, 'No Disposisi', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'No Surat Masuk', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Tanggal Disposisi', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Status', 1, 0, 'C', true);
    $pdf->Cell(60, 10, 'Pegawai', 1, 1, 'C', true);
    while ($row = mysqli_fetch_assoc($resultDisposisi)) {
        $pdf->Cell(30, 10, $row['idDisposisi'], 1);
        $pdf->Cell(30, 10, $row['nosuratmasuk'], 1);
        $pdf->Cell(40, 10, date('d-m-Y', strtotime($row['tanggaldisposisi'])), 1);
        $pdf->Cell(30, 10, $row['status'], 1);
        $pdf->Cell(60, 10, $row['namalengkap'], 1);
        $pdf->Ln();
    }
}
    $pdf->Ln(); 

   // Bagian Status Disposisi
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Status Disposisi', 0, 1);
$pdf->SetFont('Arial', '', 10);

// Menetapkan warna latar belakang header tabel
$pdf->SetFillColor(100, 150, 255); // Warna latar belakang header tabel

// Membuat header tabel
$pdf->Cell(140, 10, 'Kategori', 1, 0, 'C', true); // Header untuk kolom Kategori
$pdf->Cell(50, 10, 'Jumlah', 1, 1, 'C', true);    // Header untuk kolom Jumlah

// Menampilkan data status disposisi
$pdf->Cell(140, 10, 'Total Disposisi', 1, 0, 'L'); // Baris untuk Total Disposisi
$pdf->Cell(50, 10, $status['total_disposisi'], 1, 1, 'C');

$pdf->Cell(140, 10, 'Belum Selesai', 1, 0, 'L');   // Baris untuk Belum Selesai
$pdf->Cell(50, 10, $status['total_belum_selesai'], 1, 1, 'C');

$pdf->Cell(140, 10, 'Selesai', 1, 0, 'L');         // Baris untuk Selesai
$pdf->Cell(50, 10, $status['total_selesai'], 1, 1, 'C');

// Pesan jika tidak ada data disposisi
if (empty($status['total_disposisi']) && empty($status['total_belum_selesai']) && empty($status['total_selesai'])) {
    $pdf->Cell(0, 10, 'Tidak ada data disposisi untuk periode ini.', 0, 1);
}


// Output PDF
// $pdf->Output('D', 'Laporan_Surat_Masuk_Keluar_Disposisi.pdf');
$pdf->Output();