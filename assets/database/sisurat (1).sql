-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Nov 2024 pada 15.56
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
(3, 1, '5371035905720001', 'pindahan dari kelurahan oeba', 'rt02', 'Disetujui', '2024-11-03 13:41:58', 'diproses', '2024-11-03 13:42:35', 'diproses', '2024-11-03 13:43:07', 'Diproses', '2024-10-27 07:30:22', '2024-10-29 02:51:59', '', 1),
(4, 7, '5371030309690003', 'untuk mengajukan bantuan pkh', 'rt02', 'Disetujui', '2024-11-03 13:41:58', 'diproses', '2024-11-03 13:42:35', 'diproses', '2024-11-03 13:43:07', 'Diproses', '2024-11-12 03:37:21', '2024-11-04 17:17:41', '', 1),
(5, 7, '5371035905720001', 'untuk mendapat bantuan dari dinas sosial', 'rt02', 'Disetujui', '2024-11-03 13:41:58', 'Ditolak', '2024-11-11 13:30:00', 'Disetujui', '2024-11-11 13:21:26', 'Ditolak', '2024-10-29 03:13:37', '2024-10-29 10:13:37', 'Pengajuan ditolak oleh Kasi', 1),
(6, 1, '5271032609980001', 'untuk mengurus bantuan', 'rt02', 'Disetujui', '2024-11-03 13:41:58', 'diproses', '2024-11-03 13:42:35', 'diproses', '2024-11-03 13:43:07', 'Diproses', '2024-11-03 03:50:30', '2024-11-03 10:50:30', '', 1),
(7, 14, '5271032609980001', 'untuk pengajuan kpr', 'rt02', 'Disetujui', '2024-11-03 13:41:58', 'diproses', '2024-11-03 13:42:35', 'Ditolak', '2024-11-11 13:26:44', 'Ditolak', '2024-11-03 03:52:47', '2024-11-03 10:52:47', '', 1),
(8, 5, '5371034503620006', '', 'rt02', 'Disetujui', '2024-11-12 06:15:49', 'Ditolak', '2024-11-12 15:13:18', 'Ditolak', '2024-11-12 06:40:18', 'Ditolak', '2024-11-12 06:14:58', '0000-00-00 00:00:00', 'file ktp yang diupload tidak terlihat', 1),
(9, 4, '5371034503620006', 'hihihihi', 'rt02', 'Disetujui', '0000-00-00 00:00:00', 'diproses', '0000-00-00 00:00:00', 'diproses', '2024-11-12 07:02:04', 'Diproses', '2024-11-12 06:43:42', '0000-00-00 00:00:00', '', 1),
(10, 1, '5371034503620006', '', 'rt02', 'Disetujui', '0000-00-00 00:00:00', 'Disetujui', '2024-11-12 15:59:39', 'Disetujui', '2024-11-12 15:45:31', 'Diterima', '2024-11-12 11:03:03', '2024-11-13 00:22:25', '', 1),
(11, 11, '5371034503620006', 'pendaftaran CPNS', 'rt02', 'Disetujui', '0000-00-00 00:00:00', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-14 15:47:29', 'Diproses', '2024-11-14 15:44:44', '0000-00-00 00:00:00', '', 1),
(12, 11, '5371032008970001', '', 'rt02', 'Disetujui', '0000-00-00 00:00:00', 'diproses', '0000-00-00 00:00:00', 'Disetujui', '2024-11-14 15:50:13', 'Diproses', '2024-11-14 15:49:40', '0000-00-00 00:00:00', '', 1);

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
(6, 1, 4, 'Surat_Keterangan_Belum_Memiliki_Rumah_Satria_Anugerah_Andreamax_Bentura.pdf'),
(7, 2, 4, 'html_tutorial.pdf'),
(8, 1, 5, 'Era reformasi 9D.docx'),
(9, 2, 5, 'Era reformasi 9D.docx'),
(15, 32, 8, 'Satria Anugerah Andreamax Bentura'),
(16, 33, 8, 'Yane Angela Parera'),
(17, 34, 8, 'mikaila'),
(18, 35, 8, 'rumah sakit w.z yohanes'),
(19, 36, 8, '2024-10-27'),
(20, 37, 8, 'Perempuan'),
(21, 49, 9, 'Surat_Keterangan_Belum_Memiliki_Rumah_Satria_Anugerah_Andreamax_Bentura.pdf'),
(22, 50, 9, 'Surat_Keterangan_Belum_Memiliki_Rumah_Satria_Anugerah_Andreamax_Bentura.pdf'),
(23, 51, 9, 'Hasil lengkap revisi 3.pdf'),
(24, 52, 9, 'Satria Anugerah Andreamax Bentura'),
(25, 53, 9, '2024-11-03'),
(26, 54, 9, 'rumah sakit'),
(27, 55, 9, 'penyakit jantung');

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
(1, '19/20/adf/10/2022', 'ikut pelatihan mewakili saya', 'Selesai', '2', '2024-10-17 07:44:04', '2024-10-16 23:42:00'),
(2, '19/20/adf/10/2022', 'ikut mewakili saya', 'Belum Selesai', '196610271986032011', '2024-11-11 20:00:25', '2024-11-11 12:00:25');

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
(13, 'surat keterangan riwayat kepemilikan tanah', '-', ''),
(14, 'surat keterangan belum memiliki rumah', 'Kel.OBA. 648.12', ''),
(15, 'surat keterangan janda/duda/pensiun', 'Kel. OBA.470 ', ''),
(16, 'surat kematian untuk penerima rastra nasional dan daerah', '-', ''),
(117, 'surat keterangan menikah', '-', ''),
(118, 'surat keterangan kehilangan', '-', ''),
(119, 'surat keterangan riwayat kepemilikan kendaraan', '-', ''),
(120, 'surat keterangan riwayat kepemilikan bangunan', '-', '');

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
('rt01', 1, '3', '2024-2029', 27),
('rt02', 13, '5371030309690003', '2024-2029', 29);

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
('1', 4, '1', '2024-2029', 23),
('2', 1, '3', '2024-2029', 26),
('3', 4, '5271032609980001', '2024-2025', 64);

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
('1', 'AYUNTHA', 'Laki-laki', '2024-10-14', 'kupang', 'Jalan Beringin', 'Kristen Protestan', '081246006312', 'staf surat', '', 1),
('196610271986032011', 'ENGGELINA MALELAK', 'Perempuan', '2024-10-28', 'kupang', 'Jalan', 'Kristen Protestan', '081246006312', 'kasi pelmas dan perlengkapan', 'Penata III/ C', 61),
('196610312007011007', 'IBRAHIM HERMANTO PASSOE, S.Sos', 'Laki-laki', '1966-10-31', 'kupang', 'Jalan', 'Kristen Protestan', '081246006312', 'lurah', 'Penata Tk. I (III/d)', 5),
('198304192015022001', 'RINA M. SAUDALE, S. Pt', 'Perempuan', '1983-04-19', 'kupang', 'jalan', 'Kristen Protestan', '08113830073', 'sekretaris lurah', 'Penata Muda Tk. I / III B', 66),
('2', 'Sin Wonlele', 'Perempuan', '2024-09-29', 'kupang', 'Jalan Ahmad Yani', 'Kristen Protestan', '081246006312', 'kepala seksi pemerintah', '', 2),
('4', 'aira', 'Perempuan', '2024-11-03', 'new york city', 'jalan', 'Kristen Protestan', '081246006312', 'lurah', '', 65),
('46', 'Ano Bere', 'Laki-laki', '2024-09-29', 'kupang', 'JALAN', 'Katolik', '081246006312', 'kasi keamanan', '', 21);

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
(20, 'Alamat', 'varchar'),
(21, 'tahun', 'varchar'),
(22, 'tanggal meninggal', 'date'),
(23, 'lokasi meninggal', 'varchar'),
(25, 'penyebab', 'varchar'),
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
(45, 'no kartu rastra', 'number'),
(46, 'status', 'varchar'),
(47, 'luas/ukuran', 'varchar'),
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
(60, 'no surat', 'varchar'),
(61, 'hubungan dengan ahli waris', 'varchar');

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
(1, 1, 7),
(2, 2, 7),
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
(38, 1, 2),
(39, 2, 2),
(40, 20, 2),
(41, 21, 2),
(42, 26, 2),
(43, 27, 2),
(44, 1, 3),
(45, 2, 3),
(46, 20, 3),
(47, 26, 3),
(48, 27, 3),
(49, 1, 4),
(50, 2, 4),
(51, 5, 4),
(52, 6, 4),
(53, 22, 4),
(54, 23, 4),
(55, 25, 4),
(56, 1, 8),
(57, 2, 8),
(58, 8, 8),
(59, 9, 8),
(64, 1, 9),
(65, 2, 9),
(75, 2, 117),
(76, 18, 117),
(77, 39, 117),
(78, 40, 117),
(79, 41, 117),
(80, 42, 117),
(81, 20, 118),
(82, 25, 118),
(83, 43, 118),
(84, 44, 118),
(85, 1, 16),
(86, 2, 16),
(87, 13, 16),
(88, 17, 16),
(89, 22, 16),
(90, 23, 16),
(91, 25, 16),
(92, 45, 16),
(93, 1, 15),
(94, 2, 15),
(95, 46, 15),
(96, 1, 1),
(97, 2, 1),
(98, 19, 1),
(99, 20, 1),
(100, 21, 1),
(117, 1, 13),
(118, 2, 13),
(119, 4, 13),
(120, 8, 13),
(121, 9, 13),
(122, 20, 13),
(123, 47, 13),
(124, 48, 13),
(125, 49, 13),
(126, 50, 13),
(129, 1, 120),
(130, 2, 120),
(131, 4, 120),
(132, 7, 120),
(133, 9, 120),
(134, 47, 120),
(135, 48, 120),
(136, 49, 120),
(137, 52, 120),
(138, 53, 120),
(139, 1, 119),
(140, 2, 119),
(141, 9, 119),
(142, 21, 119),
(143, 50, 119),
(144, 53, 119),
(145, 54, 119),
(146, 55, 119),
(147, 56, 119),
(148, 57, 119),
(149, 58, 119),
(150, 59, 119),
(151, 1, 12),
(152, 2, 12),
(153, 7, 12),
(154, 8, 12),
(155, 9, 12),
(156, 20, 12),
(157, 21, 12),
(158, 47, 12),
(159, 48, 12),
(160, 51, 12),
(161, 1, 10),
(162, 2, 10),
(163, 4, 10),
(164, 6, 10),
(165, 7, 10),
(166, 15, 10),
(167, 22, 10),
(168, 60, 10),
(169, 61, 10),
(170, 1, 11),
(171, 2, 11);

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
('19/20/adf/10/2022', '2024-09-01', 'UNDANGAN KERJA ', 'NetAcad Learning Transcript.pdf', 'PT SEJAHTERA GROUP', 1);

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
(79, 5, '1', '/1/11/2024', 'Surat_Keterangan_Tidak_Mampu_Amelia Radja Leba.pdf'),
(88, 8, '1', 'KEL.OBA.474.1/1/11/2024', 'Surat_Keterangan_Kelahiran_Yane Angela Parera.pdf'),
(89, 9, '1', 'KEL.OBA.474.3/1/11/2024', ''),
(90, 9, '1', 'KEL.OBA.474.3/1/11/2024', ''),
(91, 9, '1', 'KEL.OBA.474.3/1/11/2024', ''),
(92, 9, '1', 'KEL.OBA.474.3/1/11/2024', ''),
(93, 9, '1', 'KEL.OBA.474.3/1/11/2024', ''),
(94, 9, '1', 'KEL.OBA.474.3/1/11/2024', ''),
(95, 9, '1', 'KEL.OBA.474.3/1/11/2024', ''),
(96, 9, '1', 'KEL.OBA.474.3/1/11/2024', ''),
(97, 9, '1', 'KEL.OBA.474.3/1/11/2024', ''),
(98, 9, '1', 'KEL.OBA.474.3/1/11/2024', ''),
(99, 9, '1', 'KEL.OBA.474.3/1/11/2024', ''),
(100, 9, '1', 'KEL.OBA.474.3/1/11/2024', ''),
(101, 9, '1', 'KEL.OBA.474.3/1/11/2024', ''),
(102, 9, '1', 'KEL.OBA.474.3/1/11/2024', ''),
(103, 9, '1', 'KEL.OBA.474.3/1/11/2024', ''),
(104, 9, '1', 'KEL.OBA.474.3/1/11/2024', 'Surat_Keterangan_Kematian_Yane Angela Parera.pdf'),
(105, 10, '1', 'KEL.OBA.474.4 /1/11/2024', 'Surat_Keterangan_Domisili_Yane Angela Parera.pdf'),
(106, 11, '1', 'Kel.OBA. 300/1/11/2024', 'Surat_Keterangan_Catatan_Kepolisian_Yane Angela Parera.pdf'),
(107, 12, '1', 'Kel.OBA. 300/1/11/2024', 'Surat_Keterangan_Catatan_Kepolisian_Imanuel Adiputra W.Bentura.pdf');

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
(1, 'ADMIN', '$2y$10$O6bCNUddwzmCuy4BK2Lj8.HNfofTGW7nJkOmjufUaoRDiO0WcDCBS', 'staf_surat'),
(2, '2', '$2y$10$JGoSKOuTOqxeFGntRe/z3.vMljTseglKJmQPUPuxIFp1r6E/3Cvwu', 'kepala_seksi'),
(5, 'lurah', '$2y$10$1tM7Q7W8P5Le65USqZBKIuJxum0E7OBQyfViGYc.Hh0ANoD3LvQDa', 'lurah'),
(21, '46', '123456', 'kepala_seksi'),
(22, '1', '1', 'warga'),
(23, 'rw0042024', '$2y$10$rI8RcB6q/2saGCMjBIYudegVtyT5CGM89BruHivm5QlGE8Q39RJ8S', 'rw'),
(25, '3', '3', 'warga'),
(26, '1_2024', '3', 'rw'),
(27, 'RT_2024', '3', 'rt'),
(28, '5371030309690003', '5371030309690003', 'warga'),
(29, 'rt13_2024', '$2y$10$mlvQ6v543utPGxuI3dpb/OX2FYdHZWKnQXxtjR6aFA/B/NHdn3SKW', 'rt'),
(30, '100', '100', 'warga'),
(32, 'ameliaradja', '$2y$10$KEjrP03l1qYvixafbB4UwuLwJLwTh7.H0iYvne84.MUs23eS/vsD2', 'warga'),
(33, '14_2024', '2', 'rt'),
(34, '5371030211840003', '5371030211840003', 'warga'),
(35, '5371032008970001', '$2y$10$KEjrP03l1qYvixafbB4UwuLwJLwTh7.H0iYvne84.MUs23eS/vsD2', 'warga'),
(61, 'enggelina', '$2y$10$QGSdCzbu82nJGKJZ9CfQY.F8mnXDECWHzxn4YVhLmH7HvaY18A9LC', 'kepala_seksi'),
(62, '5271032609980001', '$2y$10$wAfndhlFKYOSg1LJvssUOePwMdV9q2sICb3MsU0zX.XGG68VLmYWm', 'warga'),
(63, '5371034503620006', '$2y$10$KEjrP03l1qYvixafbB4UwuLwJLwTh7.H0iYvne84.MUs23eS/vsD2', 'warga'),
(64, 'rw4_2024', '$2y$10$oZdPmI68.QjVhi7wGjvzcOmDU89NayEFsUeEFlalgebL1kOCI.PY6', 'rw'),
(65, '4', '$2y$10$ymAIsxyNbmFWj2JUX2dQrub6MS5KVAWQytwmsa6A92D5ad07QnxBa', 'lurah'),
(66, '198304192015022001', '$2y$10$wmqh0gxbvR3UQ24UHzTsQedsB3qlWLHfXMCXERu31FHlmjLhnKvFa', 'staf_surat');

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
('1', '1', 'Sin Wonlele', 'Perempuan', '2024-09-29', 'kupang', 'Jalan Ahmad Yani No 10 Rt 14 Rw 004', 'Kristen Protestan', 'menikah', 'ibu rumah tangga', 22),
('100', '1', 'Sherly', 'Laki-laki', '2024-10-20', 'soe', 'Jalan Rt 01 Rw 001', 'Kristen Protestan', 'menikah', 'seniman', 30),
('3', '1', 'Sherly', 'Perempuan', '2024-09-30', 'kupang', 'Jalan Ahmad Yani No 10 Rt 01 Rw 001\r\n', 'Kristen Protestan', 'menikah', 'pelajar', 25),
('5271032609980001', '53710322512090856', 'Satria Anugerah Andreamax Bentura', 'Laki-laki', '1998-09-26', 'kupang', 'Jalan Beringin No 2 Rt 13 Rw 004', 'Kristen Protestan', 'menikah', 'mahasiswa', 62),
('5371030211840003', '53710322512090856', 'Lukas Thimotius Bentura', 'Laki-laki', '1984-11-02', 'kupang', 'Jalan Beringin No 2 Rt 13 Rw 004', 'Kristen Protestan', 'menikah', 'kariawan swasta', 34),
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
  MODIFY `idberkassurat` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `berkaspersyaratan`
--
ALTER TABLE `berkaspersyaratan`
  MODIFY `idberkaspersyaratan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `idDisposisi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `idsuratkeluar` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

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
