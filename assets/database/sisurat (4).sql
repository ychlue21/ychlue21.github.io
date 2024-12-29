-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Nov 2024 pada 22.59
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sisurat`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `berkaspengajuansuratkeluar`
--

CREATE TABLE `berkaspengajuansuratkeluar` (
  `idberkassurat` int(10) NOT NULL,
  `Idjenisurat` int(10) NOT NULL,
  `NIK` char(20) NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `idRT` char(10) NOT NULL,
  `status_rt` enum('Disetujui','Ditolak','diproses') NOT NULL,
  `Konfirmasi_rt` datetime NOT NULL DEFAULT current_timestamp(),
  `Status_kasi` enum('Disetujui','Ditolak','diproses') NOT NULL,
  `Konfirmasi_kasi` datetime NOT NULL DEFAULT current_timestamp(),
  `status_stafsurat` enum('Disetujui','Ditolak','diproses') NOT NULL,
  `Konfirmasi_stafsurat` datetime NOT NULL DEFAULT current_timestamp(),
  `status_surat` enum('Diproses','Diterima','Ditolak') NOT NULL,
  `tanggalpengajuan` datetime NOT NULL,
  `tanggalselesai` datetime NOT NULL DEFAULT current_timestamp(),
  `keterangan` text NOT NULL,
  `is_viewed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `berkaspengajuansuratkeluar`
--

INSERT INTO `berkaspengajuansuratkeluar` (`idberkassurat`, `Idjenisurat`, `NIK`, `tujuan`, `idRT`, `status_rt`, `Konfirmasi_rt`, `Status_kasi`, `Konfirmasi_kasi`, `status_stafsurat`, `Konfirmasi_stafsurat`, `status_surat`, `tanggalpengajuan`, `tanggalselesai`, `keterangan`, `is_viewed`) VALUES
(1, 1, '5371030309690003', 'untuk pembuatan kartu keluarga baru', 'rt02', 'Disetujui', '2024-11-21 20:50:15', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 20:50:26', 'Diproses', '2024-11-21 20:48:34', '0000-00-00 00:00:00', '', 0),
(2, 2, '5371030309690003', 'pengajuan pinjaman bank BRI', 'rt02', 'Disetujui', '2024-11-21 20:53:06', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 20:56:30', 'Diproses', '2024-11-21 20:52:55', '0000-00-00 00:00:00', '', 0),
(3, 3, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 20:58:56', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 20:59:01', 'Diproses', '2024-11-21 20:57:44', '0000-00-00 00:00:00', '', 0),
(4, 4, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 21:01:10', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 21:01:17', 'Diproses', '2024-11-21 21:01:04', '0000-00-00 00:00:00', '', 0),
(5, 5, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 21:02:57', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 21:05:56', 'Diproses', '2024-11-21 21:02:51', '0000-00-00 00:00:00', '', 0),
(6, 6, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 21:58:08', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 22:01:22', 'Diproses', '2024-11-21 21:53:21', '0000-00-00 00:00:00', '', 0),
(7, 7, '5371030309690003', 'untuk mendapatkan bantuan dari dinas sosial kota kupang\r\n', 'rt02', 'Disetujui', '2024-11-21 22:04:32', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 22:04:38', 'Diproses', '2024-11-21 22:02:48', '0000-00-00 00:00:00', '', 0),
(8, 8, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 22:08:21', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 22:08:30', 'Diproses', '2024-11-21 22:05:48', '0000-00-00 00:00:00', '', 0),
(9, 9, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 22:13:55', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 22:17:08', 'Diproses', '2024-11-21 22:13:22', '0000-00-00 00:00:00', '', 0),
(10, 10, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 22:22:32', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 22:23:10', 'Diproses', '2024-11-21 22:22:27', '0000-00-00 00:00:00', '', 0),
(11, 11, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 22:26:12', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 22:28:42', 'Diproses', '2024-11-21 22:25:56', '0000-00-00 00:00:00', '', 0),
(12, 12, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 22:38:42', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 22:47:58', 'Diproses', '2024-11-21 22:38:33', '0000-00-00 00:00:00', '', 0),
(13, 15, '5371030309690003', 'persyaratan pengambilan data pensiun', 'rt02', 'Disetujui', '2024-11-21 22:55:25', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-22 02:01:50', 'Diproses', '2024-11-21 22:55:17', '0000-00-00 00:00:00', '', 0),
(14, 14, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 22:58:41', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 22:58:52', 'Diproses', '2024-11-21 22:58:35', '0000-00-00 00:00:00', '', 0),
(15, 17, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 23:00:43', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-22 22:50:33', 'Diproses', '2024-11-21 23:00:37', '0000-00-00 00:00:00', '', 0),
(16, 13, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 23:02:25', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-22 14:50:07', 'Diproses', '2024-11-21 23:02:16', '0000-00-00 00:00:00', '', 0),
(17, 16, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 23:04:18', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-22 14:17:37', 'Diproses', '2024-11-21 23:04:10', '0000-00-00 00:00:00', '', 0),
(18, 18, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 23:05:29', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 23:06:07', 'Diproses', '2024-11-21 23:05:20', '0000-00-00 00:00:00', '', 0),
(19, 20, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 23:25:32', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 23:25:41', 'Diproses', '2024-11-21 23:25:23', '0000-00-00 00:00:00', '', 0),
(20, 19, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-21 23:35:12', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-21 23:38:26', 'Diproses', '2024-11-21 23:35:01', '0000-00-00 00:00:00', '', 0),
(21, 16, '5371030309690003', '', 'rt02', 'Disetujui', '2024-11-22 14:30:38', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-22 14:49:05', 'Diproses', '2024-11-22 14:30:00', '0000-00-00 00:00:00', '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `berkaspersyaratan`
--

CREATE TABLE `berkaspersyaratan` (
  `idberkaspersyaratan` int(10) NOT NULL,
  `idpersyaratanberkassurat` int(10) NOT NULL,
  `idberkassurat` int(10) NOT NULL,
  `fileberkas` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `berkaspersyaratan`
--

INSERT INTO `berkaspersyaratan` (`idberkaspersyaratan`, `idpersyaratanberkassurat`, `idberkassurat`, `fileberkas`) VALUES
(1, 99, 1, 'jalan sudirman kuanino'),
(2, 100, 1, '2023'),
(3, 199, 2, 'Moonlit Bakes'),
(4, 200, 2, 'toko kue dan roti'),
(5, 201, 2, 'jalan ahmad yani no 114 rt 14 rw 004'),
(6, 202, 2, '2022'),
(7, 205, 3, 'Moonlit Bakes'),
(8, 206, 3, 'toko kue dan roti'),
(9, 207, 3, 'jalan ahmad yani'),
(10, 52, 4, 'Yane Angela Parera'),
(11, 53, 4, '2024-11-10'),
(12, 54, 4, 'rumah sakit'),
(13, 55, 4, 'serangan jantung'),
(14, 32, 5, 'Willem Jorhans Bentura'),
(15, 33, 5, 'Amelia Radja Leba'),
(16, 34, 5, 'bella'),
(17, 35, 5, 'rumah sakit'),
(18, 36, 5, '2024-11-17'),
(19, 37, 5, 'Perempuan'),
(20, 28, 6, 'jogjakarta'),
(21, 29, 6, '1'),
(22, 30, 6, 'mutasi kerja'),
(23, 31, 6, '2024-11-26'),
(24, 237, 8, '2024-11-25'),
(25, 238, 8, '2024-12-29'),
(26, 191, 10, 'Amelia Radja Leba'),
(27, 194, 10, '2024-11-18'),
(28, 195, 10, '1111111'),
(29, 196, 10, 'suami'),
(30, 213, 12, '15 x 7 M²'),
(31, 214, 12, '111111111111111'),
(32, 215, 12, 'ruko'),
(33, 216, 12, 'Permanen'),
(34, 217, 12, '2/seng'),
(35, 218, 12, 'jalan sudirman kuanino'),
(36, 95, 13, 'Pensiun'),
(37, 77, 15, 'Amelia Radja Leba'),
(38, 79, 15, '2024-11-03'),
(39, 80, 15, 'gereja ebenhaezer oeba'),
(40, 224, 16, '15 x 7 M²'),
(41, 225, 16, '1111111111111'),
(42, 226, 16, 'Amelia Radja Leba'),
(43, 227, 16, '2020'),
(44, 228, 16, 'jalan ahmad yani'),
(49, 241, 18, 'ktp, atm bri'),
(50, 242, 18, '2024-11-21'),
(51, 243, 18, 'jatuh'),
(52, 244, 18, 'jalan sudirman kuanino'),
(53, 262, 19, '15 x 7 M²'),
(54, 263, 19, '11111111111'),
(55, 264, 19, 'Amelia Radja Leba'),
(56, 265, 19, '2024-11-03'),
(57, 266, 19, 'rumah'),
(58, 267, 19, 'jalan ahmad yani'),
(59, 271, 20, 'Amelia Radja Leba'),
(60, 272, 20, '2020'),
(61, 273, 20, '2024-11-20'),
(62, 274, 20, 'motor'),
(63, 275, 20, 'honda'),
(64, 276, 20, 'DH 1973 GF'),
(65, 277, 20, 'putih'),
(66, 279, 21, 'Amelia Radja Leba'),
(67, 280, 21, 'The king spesial.pdf'),
(68, 281, 21, 'The king.pdf'),
(69, 282, 21, '2024-11-06'),
(70, 283, 21, 'Amelia Radja Leba'),
(71, 284, 21, 'Moonlit Bakes'),
(72, 285, 21, 'jogjakarta');

-- --------------------------------------------------------

--
-- Struktur dari tabel `disposisi`
--

CREATE TABLE `disposisi` (
  `idDisposisi` int(10) NOT NULL,
  `nosurat` varchar(255) NOT NULL,
  `isiDisposisi` text NOT NULL,
  `status` enum('Belum Selesai','Selesai') NOT NULL,
  `idpegawai` char(20) NOT NULL,
  `tanggaldisposisi` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tanggal_verifikasi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `disposisi`
--

INSERT INTO `disposisi` (`idDisposisi`, `nosurat`, `isiDisposisi`, `status`, `idpegawai`, `tanggaldisposisi`, `tanggal_verifikasi`) VALUES
(2, '19/20/adf/10/2022', 'ikut mewakili saya', 'Selesai', '196610271986032011', '2024-11-18 12:18:28', '2024-11-11 12:00:25'),
(3, 'kel.oeb', 'siapkan 50 warga\r\n', 'Selesai', '196610271986032011', '2024-11-18 12:18:26', '2024-11-17 11:02:46'),
(4, 'kel.oeb', 'heh', 'Selesai', '196610271986032011', '2024-11-18 12:17:06', '2024-11-17 15:32:00'),
(5, 'kel.oeb', 'heh', 'Selesai', '196610271986032011', '2024-11-18 12:17:06', '2024-11-17 15:32:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenissurat`
--

CREATE TABLE `jenissurat` (
  `idJenisSurat` int(10) NOT NULL,
  `jenissurat` varchar(255) NOT NULL,
  `kodesurat` varchar(255) NOT NULL,
  `isi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenissurat`
--

INSERT INTO `jenissurat` (`idJenisSurat`, `jenissurat`, `kodesurat`, `isi`) VALUES
(1, 'surat keterangan domisili', 'KEL.OBA.474.4 ', ''),
(2, 'surat keterangan usaha', 'Kel.OBA. 500 ', ''),
(3, 'surat ijin tempat usaha', 'Kel.OBA. 510 ', ''),
(4, 'surat keterangan kematian', 'KEL.OBA.474.3', ''),
(5, 'surat keterangan kelahiran', 'KEL.OBA.474.1', ''),
(6, 'surat keterangan pindah', 'Kel.OBA.475 ', ''),
(7, 'surat keterangan tidak mampu', 'Kel.OBA. 581', ''),
(8, 'surat keterangan membangun', 'kel.oba.421.3.', ''),
(9, 'surat keterangan belum menikah', 'Kel.OBA. 474.2 ', ''),
(10, 'surat keterangan ahli waris', 'KEL.OBA.474.4 ', ''),
(11, 'surat keterangan catatan kepolisian', 'Kel.OBA. 300', ''),
(12, 'surat keterangan IMB', 'Kel. OBA. 503', ''),
(13, 'surat keterangan riwayat kepemilikan tanah', 'KEL. OBA 600.1', ''),
(14, 'surat keterangan belum memiliki rumah', 'Kel.OBA. 648.12', ''),
(15, 'surat keterangan janda duda pensiun', 'Kel. OBA.470 ', ''),
(16, 'surat kematian untuk penerima rastra nasional dan daerah', 'KEL.OBA.474.4', ''),
(17, 'surat keterangan menikah', 'Kel.OBA. 474.1\r\n', ''),
(18, 'surat keterangan kehilangan', 'Kel.OBA. 301\r\n', ''),
(19, 'surat keterangan riwayat kepemilikan kendaraan', 'KEL. OBA 600.2', ''),
(20, 'surat keterangan riwayat kepemilikan bangunan', 'KEL. OBA 600.3', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ketua_rt`
--

CREATE TABLE `ketua_rt` (
  `IDKETUART` char(10) NOT NULL,
  `IDRT` int(5) NOT NULL,
  `NIK` char(20) NOT NULL,
  `TAHUN_JABATAN` char(10) NOT NULL,
  `iduser` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ketua_rt`
--

INSERT INTO `ketua_rt` (`IDKETUART`, `IDRT`, `NIK`, `TAHUN_JABATAN`, `iduser`) VALUES
('rt02', 13, '5371030309690003', '2024-2025', 29);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ketua_rw`
--

CREATE TABLE `ketua_rw` (
  `IDKETUARW` char(10) NOT NULL,
  `IDRW` int(5) NOT NULL,
  `NIK` char(20) NOT NULL,
  `TAHUN_JABATAN` char(10) NOT NULL,
  `iduser` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ketua_rw`
--

INSERT INTO `ketua_rw` (`IDKETUARW`, `IDRW`, `NIK`, `TAHUN_JABATAN`, `iduser`) VALUES
('3', 4, '5271032609980001', '2024-2025', 64),
('4', 4, '5371030309690003', '2029-2034', 67);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `idPegawai` char(20) NOT NULL,
  `namalengkap` varchar(255) NOT NULL,
  `JK` enum('Perempuan','Laki-laki') NOT NULL,
  `Tanggal_lahir` date NOT NULL,
  `Tempat_lahir` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `agama` enum('Kristen Protestan','Katolik','Islam','Hindu','Buddha','Konghucu') NOT NULL,
  `no_hp` char(20) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `pangkat_gol` varchar(255) NOT NULL,
  `iduser` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`idPegawai`, `namalengkap`, `JK`, `Tanggal_lahir`, `Tempat_lahir`, `alamat`, `agama`, `no_hp`, `jabatan`, `pangkat_gol`, `iduser`) VALUES
('196610271986032011', 'ENGGELINA MALELAK', 'Perempuan', '2024-10-28', 'kupang', 'Jalan', 'Kristen Protestan', '081246006312', 'kepala seksi pemerintah', 'Penata III/ C', 61),
('196610312007011007', 'IBRAHIM HERMANTO PASSOE, S.Sos', 'Laki-laki', '1966-10-31', 'kupang', 'Jalan', 'Kristen Protestan', '081246006312', 'lurah', 'Penata Tk. I (III/d)', 5),
('198304192015022001', 'RINA M. SAUDALE, S. Pt', 'Perempuan', '1983-04-19', 'kupang', 'jalan', 'Kristen Protestan', '08113830073', 'sekretaris lurah', 'Penata Muda Tk. I / III B', 66);

-- --------------------------------------------------------

--
-- Struktur dari tabel `persyaratan`
--

CREATE TABLE `persyaratan` (
  `idpersyaratan` int(10) NOT NULL,
  `persyaratan` varchar(255) NOT NULL,
  `tipe_field` enum('text','number','date','varchar') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `persyaratan`
--

INSERT INTO `persyaratan` (`idpersyaratan`, `persyaratan`, `tipe_field`) VALUES
(1, 'KTP', 'text'),
(2, 'Kartu keluarga\r\n', 'text'),
(3, 'surat keterangan rumah sakit', 'text'),
(4, 'KTP saksi', 'text'),
(5, 'KTP pelapor', 'text'),
(6, 'Nama alm.', 'varchar'),
(7, 'Akta kepemilikan', 'text'),
(8, 'sertifikat tanah\r\n', 'text'),
(9, 'Bukti pajak 3 tahun terakhir', 'text'),
(10, 'surat penelitian', 'text'),
(11, 'proposal penelitian', 'text'),
(12, 'akta kelahiran', 'text'),
(13, 'foto buku rekening bank NTT', 'text'),
(14, 'surat keterangan tidak mampu', 'text'),
(15, 'KTP ahli waris', 'text'),
(16, 'STPJN', 'text'),
(17, 'surat keterangan kematian', 'text'),
(18, 'akta nikah\r\n', 'text'),
(19, 'surat pindah dari daerah asal\r\n', 'text'),
(20, 'Alamat asal\r\n', 'varchar'),
(21, 'tahun pindah\r\n', 'varchar'),
(22, 'tanggal meninggal', 'date'),
(23, 'lokasi meninggal', 'varchar'),
(25, 'penyebab meninggal\r\n', 'varchar'),
(26, 'Nama Usaha', 'varchar'),
(27, 'jenis usaha', 'varchar'),
(28, 'bukti dari rumah sakit', 'text'),
(29, 'alamat pindah', 'varchar'),
(30, 'jumlah yang ikut', 'number'),
(31, 'Alasan pindah', 'varchar'),
(32, 'tanggal pindah', 'date'),
(33, 'Nama Ayah', 'varchar'),
(34, 'Nama Ibu', 'varchar'),
(35, 'nama anak', 'varchar'),
(36, 'lokasi melahirkan', 'varchar'),
(37, 'tanggal lahir', 'date'),
(38, 'jenis kelamin', 'varchar'),
(39, 'nama pasangan', 'varchar'),
(40, 'ktp pasangan', 'text'),
(41, 'tanggal nikah', 'date'),
(42, 'lokasi menikah', 'varchar'),
(43, 'barang yang hilang', 'varchar'),
(44, 'waktu kejadian', 'date'),
(45, 'no kartu rastra', 'varchar'),
(46, 'status', 'varchar'),
(47, 'luas bangunan atau tanah', 'varchar'),
(48, 'no sertifikat', 'varchar'),
(49, 'nama pemilik sebelumnya', 'varchar'),
(50, 'tahun kepemilikan sebelumnya', 'varchar'),
(51, 'tahun pembangunan', 'varchar'),
(52, 'tanggal peralihan', 'date'),
(53, 'Jenis bangunan', 'varchar'),
(54, 'jenis kendaraan', 'varchar'),
(55, 'merek kendaraan', 'varchar'),
(56, 'nomor plat kendaraan', 'varchar'),
(57, 'warna', 'varchar'),
(58, 'bukti kepemilikan kendaraan', 'text'),
(59, 'keterangan transaksi', 'varchar'),
(60, 'no surat kematian\r\n', 'varchar'),
(61, 'hubungan dengan ahli waris', 'varchar'),
(62, 'Bentuk bangunan', 'varchar'),
(63, 'lantai/atap', 'varchar'),
(64, 'lokasi usaha', 'varchar'),
(65, 'Tahun memulai usaha\r\n', 'varchar'),
(66, 'lokasi pembangunan/tanah/bangunan\r\n', 'varchar'),
(67, 'penyebab kehilangan', 'varchar'),
(68, 'Lokasi menghilang', 'varchar'),
(69, 'tanggal mulai membangun', 'date'),
(70, 'tanggal selesai membangun', 'date'),
(71, 'tahun kendaraan', 'varchar');

-- --------------------------------------------------------

--
-- Struktur dari tabel `persyaratanjenissurat`
--

CREATE TABLE `persyaratanjenissurat` (
  `idpersyaratanberkassurat` int(10) NOT NULL,
  `idpersyaratan` int(10) NOT NULL,
  `idjenissurat` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `persyaratanjenissurat`
--

INSERT INTO `persyaratanjenissurat` (`idpersyaratanberkassurat`, `idpersyaratan`, `idjenissurat`) VALUES
(28, 29, 6),
(29, 30, 6),
(30, 31, 6),
(31, 32, 6),
(32, 33, 5),
(33, 34, 5),
(34, 35, 5),
(35, 36, 5),
(36, 37, 5),
(37, 38, 5),
(49, 1, 4),
(50, 2, 4),
(51, 5, 4),
(52, 6, 4),
(53, 22, 4),
(54, 23, 4),
(55, 25, 4),
(75, 2, 17),
(76, 18, 17),
(77, 39, 17),
(78, 40, 17),
(79, 41, 17),
(80, 42, 17),
(93, 1, 15),
(94, 2, 15),
(95, 46, 15),
(96, 1, 1),
(97, 2, 1),
(98, 19, 1),
(99, 20, 1),
(100, 21, 1),
(188, 1, 10),
(189, 2, 10),
(190, 4, 10),
(191, 6, 10),
(192, 7, 10),
(193, 15, 10),
(194, 22, 10),
(195, 60, 10),
(196, 61, 10),
(197, 1, 2),
(198, 2, 2),
(199, 26, 2),
(200, 27, 2),
(201, 64, 2),
(202, 65, 2),
(203, 1, 3),
(204, 2, 3),
(205, 26, 3),
(206, 27, 3),
(207, 64, 3),
(208, 1, 12),
(209, 2, 12),
(210, 7, 12),
(211, 8, 12),
(212, 9, 12),
(213, 47, 12),
(214, 48, 12),
(215, 53, 12),
(216, 62, 12),
(217, 63, 12),
(218, 66, 12),
(219, 1, 13),
(220, 2, 13),
(221, 4, 13),
(222, 8, 13),
(223, 9, 13),
(224, 47, 13),
(225, 48, 13),
(226, 49, 13),
(227, 50, 13),
(228, 66, 13),
(233, 1, 8),
(234, 2, 8),
(235, 8, 8),
(236, 9, 8),
(237, 69, 8),
(238, 70, 8),
(241, 43, 18),
(242, 44, 18),
(243, 67, 18),
(244, 68, 18),
(257, 1, 20),
(258, 2, 20),
(259, 4, 20),
(260, 7, 20),
(261, 9, 20),
(262, 47, 20),
(263, 48, 20),
(264, 49, 20),
(265, 52, 20),
(266, 53, 20),
(267, 66, 20),
(268, 1, 19),
(269, 2, 19),
(270, 9, 19),
(271, 49, 19),
(272, 50, 19),
(273, 52, 19),
(274, 54, 19),
(275, 55, 19),
(276, 56, 19),
(277, 57, 19),
(278, 58, 19),
(279, 6, 16),
(280, 13, 16),
(281, 17, 16),
(282, 22, 16),
(283, 23, 16),
(284, 25, 16),
(285, 45, 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rt`
--

CREATE TABLE `rt` (
  `IDRT` int(5) NOT NULL,
  `NAMA_RT` varchar(255) NOT NULL,
  `IDRW` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rt`
--

INSERT INTO `rt` (`IDRT`, `NAMA_RT`, `IDRW`) VALUES
(1, 'RT 01', 1),
(2, 'RT 02', 1),
(3, 'RT 03', 1),
(4, 'RT 04', 2),
(5, 'RT 05', 2),
(6, 'RT 06', 2),
(7, 'RT 07', 2),
(8, 'RT 08', 3),
(9, 'RT 09', 3),
(10, 'RT 10', 3),
(11, 'RT 11', 3),
(12, 'RT 12', 4),
(13, 'RT 13', 4),
(14, 'RT 14', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rw`
--

CREATE TABLE `rw` (
  `IDRW` int(5) NOT NULL,
  `NAMA_RW` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rw`
--

INSERT INTO `rw` (`IDRW`, `NAMA_RW`) VALUES
(1, 'RW 001'),
(2, 'RW 002'),
(3, 'RW 003'),
(4, 'RW 004');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suratmasuk`
--

CREATE TABLE `suratmasuk` (
  `nosuratmasuk` varchar(255) NOT NULL,
  `tanggalsurat` date NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `filesurat` text NOT NULL,
  `pengirim` varchar(255) NOT NULL,
  `is_viewed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `suratmasuk`
--

INSERT INTO `suratmasuk` (`nosuratmasuk`, `tanggalsurat`, `tujuan`, `filesurat`, `pengirim`, `is_viewed`) VALUES
('1234', '2024-11-17', 'UNDANGAN RAPAT', 'Laporan_Surat_Masuk_Keluar_Disposisi.pdf', 'PT SEJAHTERA', 1),
('19/20/adf/10/2022', '2024-09-01', 'UNDANGAN KERJA ', 'NetAcad Learning Transcript.pdf', 'PT SEJAHTERA GROUP', 1),
('kel.oeb', '2024-11-11', 'perkunjungan ', 'rancangan_tabel_surat_keluar.pdf', 'pt agung sejahtera', 1),
('kel.oeb.420', '2024-11-18', 'sosialisasi ', '98c7f091711932901e17d01fbfde1db4.pdf', 'dinas pendidikan ', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_keluar`
--

CREATE TABLE `surat_keluar` (
  `idsuratkeluar` int(10) NOT NULL,
  `idberkassuratkeluar` int(10) NOT NULL,
  `idpegawai` char(20) NOT NULL,
  `nosurat` varchar(255) NOT NULL,
  `filesurat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `surat_keluar`
--

INSERT INTO `surat_keluar` (`idsuratkeluar`, `idberkassuratkeluar`, `idpegawai`, `nosurat`, `filesurat`) VALUES
(260, 1, '198304192015022001', 'KEL.OBA.474.4 /1/11/2024', 'Surat_Keterangan_Domisili_Willem Jorhans Bentura.pdf'),
(262, 2, '198304192015022001', 'Kel.OBA. 500 /1/11/2024', 'Surat_Keterangan_Usaha_Willem Jorhans Bentura.pdf'),
(263, 3, '198304192015022001', 'Kel.OBA. 510 /1/11/2024', 'Surat_Ijin_Tempat_Usaha_Willem Jorhans Bentura.pdf'),
(264, 4, '198304192015022001', 'KEL.OBA.474.3/1/11/2024', 'Surat_Keterangan_Kematian_Willem Jorhans Bentura.pdf'),
(265, 5, '198304192015022001', 'KEL.OBA.474.1/1/11/2024', 'Surat_Keterangan_Kelahiran_Willem Jorhans Bentura.pdf'),
(266, 5, '198304192015022001', 'KEL.OBA.474.1/2/11/2024', 'Surat_Keterangan_Kelahiran_Willem Jorhans Bentura.pdf'),
(268, 6, '198304192015022001', 'Kel.OBA.475 /2/11/2024', 'Surat_Keterangan_Domisili_Willem Jorhans Bentura.pdf'),
(269, 6, '198304192015022001', 'Kel.OBA.475 /3/11/2024', 'Surat_Keterangan_Domisili_Willem Jorhans Bentura.pdf'),
(270, 6, '198304192015022001', 'Kel.OBA.475 /4/11/2024', 'Surat_Keterangan_Domisili_Willem Jorhans Bentura.pdf'),
(271, 6, '198304192015022001', 'Kel.OBA.475 /5/11/2024', 'Surat_Keterangan_Domisili_Willem Jorhans Bentura.pdf'),
(272, 6, '198304192015022001', 'Kel.OBA.475 /6/11/2024', 'Surat_Keterangan_Domisili_Willem Jorhans Bentura.pdf'),
(273, 6, '198304192015022001', 'Kel.OBA.475 /7/11/2024', 'Surat_Keterangan_Domisili_Willem Jorhans Bentura.pdf'),
(274, 6, '198304192015022001', 'Kel.OBA.475 /8/11/2024', 'Surat_Keterangan_Domisili_Willem Jorhans Bentura.pdf'),
(275, 6, '198304192015022001', 'Kel.OBA.475 /9/11/2024', 'Surat_Keterangan_Domisili_Willem Jorhans Bentura.pdf'),
(276, 7, '198304192015022001', 'Kel.OBA. 581/1/11/2024', 'Surat_Keterangan_Tidak_Mampu_Willem Jorhans Bentura.pdf'),
(277, 8, '198304192015022001', 'kel.oba.421.3./1/11/2024', 'Surat_Keterangan_Membangun_Willem_Jorhans_Bentura.pdf'),
(278, 9, '198304192015022001', 'Kel.OBA. 474.2 /1/11/2024', 'Surat_Keterangan_Belum_Menikah_Willem Jorhans Bentura.pdf'),
(279, 9, '198304192015022001', 'Kel.OBA. 474.2 /2/11/2024', 'Surat_Keterangan_Belum_Menikah_Willem Jorhans Bentura.pdf'),
(280, 10, '198304192015022001', 'KEL.OBA.474.4 /1/11/2024', 'Surat_Keterangan_Ahli_Waris_Willem Jorhans Bentura.pdf'),
(281, 11, '198304192015022001', 'Kel.OBA. 300/1/11/2024', 'Surat_Keterangan_Catatan_Kepolisian_Willem Jorhans Bentura.pdf'),
(282, 12, '198304192015022001', 'Kel. OBA. 503/1/11/2024', 'SURAT KETERANGAN IMB_Willem Jorhans Bentura.pdf'),
(283, 12, '198304192015022001', 'Kel. OBA. 503/2/11/2024', 'SURAT KETERANGAN IMB_Willem Jorhans Bentura.pdf'),
(284, 12, '198304192015022001', 'Kel. OBA. 503/3/11/2024', 'SURAT KETERANGAN IMB_Willem Jorhans Bentura.pdf'),
(285, 12, '198304192015022001', 'Kel. OBA. 503/4/11/2024', 'SURAT KETERANGAN IMB_Willem Jorhans Bentura.pdf'),
(286, 13, '198304192015022001', 'Kel. OBA.470 /1/11/2024', ''),
(287, 13, '198304192015022001', 'Kel. OBA.470 /2/11/2024', ''),
(288, 13, '198304192015022001', 'Kel. OBA.470 /3/11/2024', ''),
(289, 13, '198304192015022001', 'Kel. OBA.470 /4/11/2024', ''),
(290, 13, '198304192015022001', 'Kel. OBA.470 /5/11/2024', ''),
(291, 13, '198304192015022001', 'Kel. OBA.470 /6/11/2024', ''),
(292, 14, '198304192015022001', 'Kel.OBA. 648.12/1/11/2024', 'Surat_Keterangan_Belum_Memiliki_Rumah_Willem_Jorhans_Bentura.pdf'),
(293, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/1/11/2024', ''),
(294, 16, '198304192015022001', 'KEL. OBA 600.1/1/11/2024', ''),
(295, 16, '198304192015022001', 'KEL. OBA 600.1/2/11/2024', 'Surat_Keterangan_Riwayat_Kepemilikan_TanahWillem Jorhans Bentura.pdf'),
(297, 18, '198304192015022001', 'Kel.OBA. 301\r\n/1/11/2024', 'Surat_Keterangan_Kehilangan_Willem Jorhans Bentura.pdf'),
(300, 20, '198304192015022001', 'KEL. OBA 600.2/2/11/2024', 'Surat_Keterangan_Riwayat_Kepemilikan_KendaraanWillem Jorhans Bentura.pdf'),
(301, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/2/11/2024', ''),
(302, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/3/11/2024', ''),
(303, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/4/11/2024', ''),
(309, 13, '198304192015022001', 'Kel. OBA.470 /12/11/2024', 'Surat_Keterangan_Willem Jorhans Bentura.pdf'),
(310, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/5/11/2024', ''),
(311, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/6/11/2024', ''),
(312, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/7/11/2024', ''),
(313, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/8/11/2024', ''),
(314, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/9/11/2024', ''),
(315, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/10/11/2024', ''),
(330, 21, '198304192015022001', 'KEL.OBA.474.4/1/11/2024', 'Surat_Kematian_Untuk_Penerima_Rastra_Nasional_Dan_Daerah_Willem Jorhans Bentura.pdf'),
(331, 21, '198304192015022001', 'KEL.OBA.474.4/2/11/2024', 'Surat_Kematian_Untuk_Penerima_Rastra_Nasional_Dan_Daerah_Willem Jorhans Bentura.pdf'),
(332, 21, '198304192015022001', 'KEL.OBA.474.4/3/11/2024', 'Surat_Kematian_Untuk_Penerima_Rastra_Nasional_Dan_Daerah_Willem Jorhans Bentura.pdf'),
(333, 16, '198304192015022001', 'KEL. OBA 600.1/3/11/2024', 'Surat_Keterangan_Riwayat_Kepemilikan_TanahWillem Jorhans Bentura.pdf'),
(334, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/11/11/2024', ''),
(335, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/12/11/2024', ''),
(336, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/13/11/2024', ''),
(337, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/14/11/2024', ''),
(338, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/15/11/2024', 'Surat_Keterangan_Menikah_Willem Jorhans Bentura.pdf'),
(339, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/16/11/2024', 'Surat_Keterangan_Menikah_Willem Jorhans Bentura.pdf'),
(340, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/17/11/2024', 'Surat_Keterangan_Menikah_Willem Jorhans Bentura.pdf'),
(341, 15, '198304192015022001', 'Kel.OBA. 474.1\r\n/18/11/2024', 'Surat_Keterangan_Menikah_Willem Jorhans Bentura.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('warga','rt','rw','staf_surat','kepala_seksi','lurah') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `role`) VALUES
(5, 'lurah', '$2y$10$1tM7Q7W8P5Le65USqZBKIuJxum0E7OBQyfViGYc.Hh0ANoD3LvQDa', 'lurah'),
(28, '5371030309690003', '$2y$10$KEjrP03l1qYvixafbB4UwuLwJLwTh7.H0iYvne84.MUs23eS/vsD2', 'warga'),
(29, 'rt13_2024', '$2y$10$mlvQ6v543utPGxuI3dpb/OX2FYdHZWKnQXxtjR6aFA/B/NHdn3SKW', 'rt'),
(32, 'ameliaradja', '$2y$10$KEjrP03l1qYvixafbB4UwuLwJLwTh7.H0iYvne84.MUs23eS/vsD2', 'warga'),
(35, '5371032008970001', '$2y$10$KEjrP03l1qYvixafbB4UwuLwJLwTh7.H0iYvne84.MUs23eS/vsD2', 'warga'),
(61, 'enggelina', '$2y$10$QGSdCzbu82nJGKJZ9CfQY.F8mnXDECWHzxn4YVhLmH7HvaY18A9LC', 'kepala_seksi'),
(62, '5271032609980001', '$2y$10$wAfndhlFKYOSg1LJvssUOePwMdV9q2sICb3MsU0zX.XGG68VLmYWm', 'warga'),
(63, '5371034503620006', '$2y$10$KEjrP03l1qYvixafbB4UwuLwJLwTh7.H0iYvne84.MUs23eS/vsD2', 'warga'),
(64, 'rw4_2024', '$2y$10$rI8RcB6q/2saGCMjBIYudegVtyT5CGM89BruHivm5QlGE8Q39RJ8S', 'rw'),
(66, '198304192015022001', '$2y$10$wmqh0gxbvR3UQ24UHzTsQedsB3qlWLHfXMCXERu31FHlmjLhnKvFa', 'staf_surat'),
(67, 'rw4_2029', '$2y$10$XFKrWrJqDLctv4H2JezNT.kNAJ1rr7sXy0jIfEmgQ0GW3/0rquxWS', 'rw');

-- --------------------------------------------------------

--
-- Struktur dari tabel `warga`
--

CREATE TABLE `warga` (
  `NIK` char(20) NOT NULL,
  `NOKK` char(20) NOT NULL,
  `namalengkap` varchar(255) NOT NULL,
  `JK` enum('Perempuan','Laki-laki') NOT NULL,
  `tgl_Lahir` date NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `agama` enum('Kristen Protestan','Katolik','Islam','Hindu','Buddha','Konghucu') NOT NULL,
  `status_perkawinan` enum('menikah','belum menikah',' cerai') NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `iduser` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `warga`
--

INSERT INTO `warga` (`NIK`, `NOKK`, `namalengkap`, `JK`, `tgl_Lahir`, `tempat_lahir`, `alamat`, `agama`, `status_perkawinan`, `pekerjaan`, `iduser`) VALUES
('5271032609980001', '53710322512090856', 'Satria Anugerah Andreamax Bentura', 'Laki-laki', '1998-09-26', 'kupang', 'Jalan Beringin No 2 Rt 13 Rw 004', 'Kristen Protestan', 'menikah', 'mahasiswa', 62),
('5371030309690003', '53710322512090856', 'Willem Jorhans Bentura', 'Laki-laki', '1969-09-03', 'kupang', 'Jl Beringin No 02 RT 13 RW 004', 'Kristen Protestan', 'menikah', 'Pegawai Negeri Sipil', 28),
('5371032008970001', '53710322512090856', 'Imanuel Adiputra W.Bentura', 'Laki-laki', '1997-08-20', 'kupang', 'Jalan Beringin No 2 Rt 13 Rw 004', 'Kristen Protestan', 'menikah', 'pelajar/mahasiswa', 35),
('5371034503620006', '5371032407080025', 'Yane Angela Parera', 'Perempuan', '1962-03-05', 'kupang', 'Jalan Belimbing Rt 13 Rw 004', 'Katolik', 'menikah', 'mengurus rumah tangga', 63),
('5371035905720001', '53710322512090856', 'Amelia Radja Leba', 'Perempuan', '1972-05-19', 'Kupang ', 'Jl Beringin No 02 RT 13 RW 004', 'Kristen Protestan', 'menikah', 'guru', 32);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `berkaspengajuansuratkeluar`
--
ALTER TABLE `berkaspengajuansuratkeluar`
  ADD PRIMARY KEY (`idberkassurat`),
  ADD KEY `Idjenisurat` (`Idjenisurat`),
  ADD KEY `NIK` (`NIK`),
  ADD KEY `idRT` (`idRT`);

--
-- Indeks untuk tabel `berkaspersyaratan`
--
ALTER TABLE `berkaspersyaratan`
  ADD PRIMARY KEY (`idberkaspersyaratan`),
  ADD KEY `idpersyaratanberkassurat` (`idpersyaratanberkassurat`),
  ADD KEY `idberkassurat` (`idberkassurat`);

--
-- Indeks untuk tabel `disposisi`
--
ALTER TABLE `disposisi`
  ADD PRIMARY KEY (`idDisposisi`),
  ADD KEY `nosuratmasuk` (`nosurat`),
  ADD KEY `idpegawai` (`idpegawai`);

--
-- Indeks untuk tabel `jenissurat`
--
ALTER TABLE `jenissurat`
  ADD PRIMARY KEY (`idJenisSurat`);

--
-- Indeks untuk tabel `ketua_rt`
--
ALTER TABLE `ketua_rt`
  ADD PRIMARY KEY (`IDKETUART`),
  ADD KEY `NIK` (`NIK`),
  ADD KEY `iduser` (`iduser`),
  ADD KEY `nama_rt` (`IDRT`);

--
-- Indeks untuk tabel `ketua_rw`
--
ALTER TABLE `ketua_rw`
  ADD PRIMARY KEY (`IDKETUARW`),
  ADD KEY `NIK` (`NIK`),
  ADD KEY `iduser` (`iduser`),
  ADD KEY `nama_rw` (`IDRW`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`idPegawai`),
  ADD KEY `iduser` (`iduser`);

--
-- Indeks untuk tabel `persyaratan`
--
ALTER TABLE `persyaratan`
  ADD PRIMARY KEY (`idpersyaratan`);

--
-- Indeks untuk tabel `persyaratanjenissurat`
--
ALTER TABLE `persyaratanjenissurat`
  ADD PRIMARY KEY (`idpersyaratanberkassurat`),
  ADD KEY `idpersyaratan` (`idpersyaratan`),
  ADD KEY `idjenissurat` (`idjenissurat`);

--
-- Indeks untuk tabel `rt`
--
ALTER TABLE `rt`
  ADD PRIMARY KEY (`IDRT`),
  ADD KEY `IDRW` (`IDRW`);

--
-- Indeks untuk tabel `rw`
--
ALTER TABLE `rw`
  ADD PRIMARY KEY (`IDRW`);

--
-- Indeks untuk tabel `suratmasuk`
--
ALTER TABLE `suratmasuk`
  ADD PRIMARY KEY (`nosuratmasuk`);

--
-- Indeks untuk tabel `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD PRIMARY KEY (`idsuratkeluar`),
  ADD KEY `idberkassuratkeluar` (`idberkassuratkeluar`),
  ADD KEY `idpegawai` (`idpegawai`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `warga`
--
ALTER TABLE `warga`
  ADD PRIMARY KEY (`NIK`),
  ADD KEY `iduser` (`iduser`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `berkaspengajuansuratkeluar`
--
ALTER TABLE `berkaspengajuansuratkeluar`
  MODIFY `idberkassurat` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `berkaspersyaratan`
--
ALTER TABLE `berkaspersyaratan`
  MODIFY `idberkaspersyaratan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `idDisposisi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `rt`
--
ALTER TABLE `rt`
  MODIFY `IDRT` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `rw`
--
ALTER TABLE `rw`
  MODIFY `IDRW` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `idsuratkeluar` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=342;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `berkaspengajuansuratkeluar`
--
ALTER TABLE `berkaspengajuansuratkeluar`
  ADD CONSTRAINT `berkaspengajuansuratkeluar_ibfk_1` FOREIGN KEY (`NIK`) REFERENCES `warga` (`NIK`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `berkaspengajuansuratkeluar_ibfk_2` FOREIGN KEY (`idRT`) REFERENCES `ketua_rt` (`IDKETUART`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `berkaspengajuansuratkeluar_ibfk_3` FOREIGN KEY (`Idjenisurat`) REFERENCES `jenissurat` (`idJenisSurat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `berkaspersyaratan`
--
ALTER TABLE `berkaspersyaratan`
  ADD CONSTRAINT `berkaspersyaratan_ibfk_1` FOREIGN KEY (`idberkassurat`) REFERENCES `berkaspengajuansuratkeluar` (`idberkassurat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `berkaspersyaratan_ibfk_2` FOREIGN KEY (`idpersyaratanberkassurat`) REFERENCES `persyaratanjenissurat` (`idpersyaratanberkassurat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `disposisi`
--
ALTER TABLE `disposisi`
  ADD CONSTRAINT `disposisi_ibfk_1` FOREIGN KEY (`idpegawai`) REFERENCES `pegawai` (`idPegawai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `disposisi_ibfk_2` FOREIGN KEY (`nosurat`) REFERENCES `suratmasuk` (`nosuratmasuk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ketua_rt`
--
ALTER TABLE `ketua_rt`
  ADD CONSTRAINT `ketua_rt_ibfk_1` FOREIGN KEY (`NIK`) REFERENCES `warga` (`NIK`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ketua_rt_ibfk_2` FOREIGN KEY (`IDRT`) REFERENCES `rt` (`IDRT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ketua_rt_ibfk_3` FOREIGN KEY (`iduser`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ketua_rw`
--
ALTER TABLE `ketua_rw`
  ADD CONSTRAINT `ketua_rw_ibfk_1` FOREIGN KEY (`NIK`) REFERENCES `warga` (`NIK`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ketua_rw_ibfk_2` FOREIGN KEY (`IDRW`) REFERENCES `rw` (`IDRW`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ketua_rw_ibfk_3` FOREIGN KEY (`iduser`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `persyaratanjenissurat`
--
ALTER TABLE `persyaratanjenissurat`
  ADD CONSTRAINT `persyaratanjenissurat_ibfk_1` FOREIGN KEY (`idjenissurat`) REFERENCES `jenissurat` (`idJenisSurat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `persyaratanjenissurat_ibfk_2` FOREIGN KEY (`idpersyaratan`) REFERENCES `persyaratan` (`idpersyaratan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rt`
--
ALTER TABLE `rt`
  ADD CONSTRAINT `rt_ibfk_1` FOREIGN KEY (`IDRW`) REFERENCES `rw` (`IDRW`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD CONSTRAINT `surat_keluar_ibfk_1` FOREIGN KEY (`idpegawai`) REFERENCES `pegawai` (`idPegawai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `surat_keluar_ibfk_2` FOREIGN KEY (`idberkassuratkeluar`) REFERENCES `berkaspengajuansuratkeluar` (`idberkassurat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `warga`
--
ALTER TABLE `warga`
  ADD CONSTRAINT `warga_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
