<?php
include('header.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}
require('../config/config.php');
$iduser= $_SESSION['user_id'];
//query untuk card data
$twarga=mysqli_query(mysql: $koneksi,query: "SELECT * FROM warga ");
$COUNT1=mysqli_num_rows(result: $twarga); //menghitung surat masuk
$tkk=mysqli_query(mysql: $koneksi,query: "SELECT NOKK FROM warga  GROUP BY NOKK");
$COUNT2=mysqli_num_rows(result: $tkk); //menghitung surat tolak
$tpegawai=mysqli_query(mysql: $koneksi,query: "SELECT * FROM pegawai");
$COUNT3=mysqli_num_rows(result: $tpegawai); //menghitung berkas pengajuan
$tsurat_masuk=mysqli_query(mysql: $koneksi,query: "SELECT * FROM suratmasuk");
$COUNT4=mysqli_num_rows(result: $tsurat_masuk); //menghitung berkas diproses
$tsurat_disposisi=mysqli_query(mysql: $koneksi,query: "SELECT * FROM disposisi");
$COUNT5=mysqli_num_rows(result: $tsurat_disposisi); //menghitung berkas diproses
$tsurat_keluar=mysqli_query(mysql: $koneksi,query: "SELECT * FROM surat_keluar");
$COUNT6=mysqli_num_rows(result: $tsurat_keluar); //menghitung berkas diproses

//QUERY UNTUK CHART
// Query untuk mendapatkan jumlah warga (pie)
$query1 = " SELECT COUNT(*) AS jumlah FROM warga where alamat like '%RW 001'";
$result1 = mysqli_query($koneksi, $query1);
$row1 = mysqli_fetch_array($result1);

$query2 = " SELECT COUNT(*) AS jumlah FROM warga where alamat like '%RW 002'";
$result2 = mysqli_query($koneksi, $query2);
$row2 = mysqli_fetch_array($result2);

$query3 = " SELECT COUNT(*) AS jumlah FROM warga where alamat like '%RW 003'";
$result3 = mysqli_query($koneksi, $query3);
$row3 = mysqli_fetch_array($result3);

$query4 = " SELECT COUNT(*) AS jumlah FROM warga where alamat like '%RW 004'";
$result4 = mysqli_query($koneksi, $query4);
$row4 = mysqli_fetch_array($result4);

$query5 = "SELECT namalengkap FROM pegawai JOIN user ON user.id_user=pegawai.iduser WHERE user.id_user = '$iduser'";
$result5 = mysqli_query($koneksi, $query5);
$row5 = mysqli_fetch_assoc($result5);
// Query untuk mendapatkan daftar jenis surat
$queryJenisSurat = "SELECT idJenisSurat, jenissurat FROM jenissurat";
$resultJenisSurat = mysqli_query($koneksi, $queryJenisSurat);
$jenisSuratList = [];
while ($rowJenisSurat = mysqli_fetch_assoc($resultJenisSurat)) {
    $jenisSuratList[$rowJenisSurat['idJenisSurat']] = $rowJenisSurat['jenissurat'];
}

// Query untuk mendapatkan daftar jenis surat
$queryJenisSurat = "SELECT idJenisSurat, jenissurat FROM jenissurat";
$resultJenisSurat = mysqli_query($koneksi, $queryJenisSurat);
$jenisSuratList = [];
while ($rowJenisSurat = mysqli_fetch_assoc($resultJenisSurat)) {
    $jenisSuratList[$rowJenisSurat['idJenisSurat']] = $rowJenisSurat['jenissurat'];
}

// Query untuk mendapatkan jumlah surat per jenis surat pada bulan ini
$query6 = "SELECT DATE_FORMAT(tanggalselesai, '%m') AS bulan, COUNT(*) AS jumlah, jenissurat, idjenissurat 
           FROM surat_keluar  
           JOIN berkaspengajuansuratkeluar ON berkaspengajuansuratkeluar.idberkassurat = surat_keluar.idberkassuratkeluar 
           JOIN jenissurat ON jenissurat.idJenisSurat = berkaspengajuansuratkeluar.Idjenisurat 
           WHERE MONTH(tanggalselesai) = MONTH(CURDATE()) AND YEAR(tanggalselesai) = YEAR(CURDATE())
           GROUP BY bulan, idjenissurat 
           ORDER BY idjenissurat ASC, bulan ASC";
$result6 = mysqli_query($koneksi, $query6);

// Menyusun data berdasarkan query 6
$dataByJenisSurat = [];

// Menyusun data berdasarkan query 6 (jumlah surat per jenis surat pada bulan ini)
while ($row6 = mysqli_fetch_assoc($result6)) {
    $idJenisSurat = $row6['idjenissurat'];
    $jumlah = $row6['jumlah'];

    // Menyimpan jumlah surat berdasarkan jenis surat yang ditemukan di query 6
    $dataByJenisSurat[$idJenisSurat] = $jumlah;
}

// Menyusun dataset untuk Chart.js
$datasets = [];
$labels = array_values($jenisSuratList);  // Menampilkan semua jenis surat pada sumbu X
$colorIndex = 0;
$colors = [
    '#FFB3BA', '#FFDFBA', '#FFFFBA', '#BAFFB3', '#BAE1FF', '#FFC3A0', '#FFB5E8', '#FFCCFF', 
    '#A9A9A9', '#B2D7FF', '#FFE4B5', '#D3FFCE', '#E6A8D7', '#FFEC40', '#FFDB58'
];

// Menyusun data untuk Chart.js
foreach ($jenisSuratList as $idJenisSurat => $namaJenisSurat) {
    // Jika jenis surat tidak ada dalam hasil query 6, set jumlahnya menjadi 0
    $jumlahSurat = isset($dataByJenisSurat[$idJenisSurat]) ? $dataByJenisSurat[$idJenisSurat] : 0;

    // Menambahkan data untuk setiap jenis surat
    $datasets[] = [
        'label' => $namaJenisSurat,  // Menampilkan nama jenis surat sebagai label
        'data' => [$jumlahSurat], // Menampilkan jumlah surat berdasarkan hasil query 6
        'backgroundColor' => $colors[$colorIndex % count($colors)],  // Menentukan warna berdasarkan urutan
        'borderColor' => $colors[$colorIndex % count($colors)],      // Border yang sama dengan warna latar belakang
        'borderWidth' => 1,
    ];
    $colorIndex++;
}

// Menyusun data akhir untuk Chart.js
$chartData = [
    'labels' => $labels,  // Menampilkan nama jenis surat pada sumbu X
    'datasets' => $datasets
];
?>

<main class="content">
    <!-- <h2 class="title">Selamat datang </h2> -->
    <?php
     if ($row5) {
    echo "  <h2 class='title' style='margin-bottom: 30px;'>Selamat datang " . strtolower($row5['namalengkap']) . "</h2>";
                }
     ?>
    <!-- AWAL CARD -->
    <div class="row">
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title font-weight-bold text-primary text-uppercase mb-1">
                                Total Warga
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $COUNT1;?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-person fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title font-weight-bold text-primary text-uppercase mb-1">
                                Total KK
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $COUNT2;?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-people-group fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title font-weight-bold text-primary text-uppercase mb-1">
                                Total Pegawai
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $COUNT3;?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-people-group fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title font-weight-bold text-primary text-uppercase mb-1">
                                Surat Masuk
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $COUNT4;?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title font-weight-bold text-primary text-uppercase mb-1">
                                Total Disposisi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $COUNT5;?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title font-weight-bold text-primary text-uppercase mb-1">
                                Total Surat Keluar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $COUNT6;?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- AWAL CHART -->
    <!-- <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Data Surat Perbulan
                </div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="50"></canvas></div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Data Warga Berdasarkan RW
                </div>
                <div class="card-body"><canvas id="myPieChart" width="100%" height="50"></canvas></div>

            </div>
        </div>
    </div> -->
    <div class="row">
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Data Surat Perbulan
                </div>
                <div class="card-body">
                    <canvas id="myAreaChart" width="100%" height="50"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Data Warga Berdasarkan RW
                </div>
                <div class="card-body">
                    <canvas id="myPieChart" width="100%" height="50"></canvas>
                </div>
            </div>
        </div>
    </div>

</main>
<script>
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["RW 001", "RW 002", "RW 003", "RW 004"],
        datasets: [{
            data: [<?php echo $row1['jumlah']; ?>, <?php echo $row2['jumlah']; ?>,
                <?php echo $row3['jumlah']; ?>, <?php echo $row4['jumlah']; ?>
            ],
            backgroundColor: ['#73EC8B', '#C4D7FF', '#E4B1F0', '#C96868'],
        }],
    },
    options: {
        plugins: {
            legend: {
                display: true, // Menampilkan legend
                position: 'top', // Posisi legend
                labels: {
                    font: {
                        size: 14, // Ukuran font legend
                    },
                    boxWidth: 20, // Ukuran kotak legend
                    padding: 10 // Padding antara teks dan kotak
                }
            }
        }
    }
});
</script>

<script>
var ctx = document.getElementById('myAreaChart').getContext('2d');

// Data untuk chart area
var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_keys($jenisSuratList)); ?>, // ID Jenis Surat pada sumbu X
        datasets: <?php
    // Membuat dataset untuk setiap ID Jenis Surat dengan warna yang berbeda
    $datasets = [];
    $colorIndex = 0;
    foreach ($jenisSuratList as $idJenisSurat => $namaJenisSurat) {
        // Inisialisasi dataForChart dengan nol untuk semua posisi
        $dataForChart = array_fill(0, count($jenisSuratList), 0);
        
        // Isi nilai data yang sesuai untuk ID Jenis Surat ini
        $index = array_search($idJenisSurat, array_keys($jenisSuratList));
        if ($index !== false) {
            $dataForChart[$index] = isset($dataByJenisSurat[$idJenisSurat]) ? $dataByJenisSurat[$idJenisSurat] : 0;
        }

        $datasets[] = [
            'label' => $idJenisSurat, // Menampilkan ID Jenis Surat pada legend
            'data' => $dataForChart, // Data untuk setiap ID Jenis Surat
            'backgroundColor' => $colors[$colorIndex % count($colors)], // Warna untuk setiap bar
            'borderColor' => $colors[$colorIndex % count($colors)], // Border warna yang sama
            'borderWidth' => 1,
            'borderRadius' => 0, // Membuat bentuk bar menjadi kotak
            'borderSkipped' => false // Menampilkan border di semua sisi
        ];
        $colorIndex++;
    }
    echo json_encode($datasets);
    ?>
    },
    options: {
        responsive: true,
        title: {
            display: true,
            text: 'Jumlah Surat Keluar Bulan: ' + new Date().toLocaleString('default', {
                month: 'long'
            }) // Title dengan bulan
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'ID Jenis Surat' // Menampilkan ID Jenis Surat pada sumbu X
                },
                ticks: {
                    autoSkip: false // Memastikan semua label tampil
                },

                barPercentage: 1.0, // Mengatur lebar bar
                categoryPercentage: 1.0 // Menyesuaikan posisi bar dalam kategori
            },
            y: {
                title: {
                    display: true,
                    text: 'Jumlah Surat' // Label untuk sumbu Y
                },
                beginAtZero: true, // Memastikan sumbu Y dimulai dari 0
                ticks: {
                    min: 0, // Menambahkan agar nilai terkecil pada sumbu Y adalah 0
                    stepSize: 1, // Memastikan sumbu Y hanya menampilkan angka bulat
                    suggestedMin: 0, // Menyediakan nilai minimum yang disarankan (0)
                    suggestedMax: Math.max(...
                        <?php echo json_encode(array_map(function($dataset) { return max($dataset['data']); }, $datasets)); ?>
                    ) + 1 // Memastikan nilai maksimum yang disarankan sesuai dengan data
                }
            }
        },
        tooltips: {
            mode: 'nearest',
            intersect: true,
            callbacks: {
                title: function(tooltipItems, data) {
                    // Mengambil index dari tooltip untuk mendapatkan data yang sesuai
                    const index = tooltipItems[0].index;
                    const idJenisSurat = data.labels[
                        index]; // Ambil ID Jenis Surat berdasarkan label yang dipilih
                    const jenisSurat = <?php echo json_encode($jenisSuratList); ?>[
                        idJenisSurat]; // Nama jenis surat dari array
                    return 'ID Jenis Surat: ' + idJenisSurat + '\nJenis Surat: ' + jenisSurat;
                },
                label: function(tooltipItem, data) {
                    const datasetIndex = tooltipItem.datasetIndex; // Indeks dataset
                    const jumlah = data.datasets[datasetIndex].data[tooltipItem
                        .index]; // Jumlah surat spesifik untuk ID Jenis Surat
                    return 'Total Surat: ' + jumlah;
                }
            }
        },


        plugins: {
            legend: {
                display: true, // Mengaktifkan legend
                position: 'top', // Posisi legend (top, left, right, bottom)
                labels: {
                    font: {
                        size: 14, // Ukuran font untuk legend
                    },
                    boxWidth: 20, // Lebar kotak untuk warna di legend
                    padding: 10, // Padding antara teks dan kotak warna
                    // Ubah label pada legend untuk menampilkan ID Jenis Surat
                    generateLabels: function(chart) {
                        var labels = [];
                        chart.data.labels.forEach(function(label, index) {
                            labels.push({
                                text: label, // Menampilkan ID Jenis Surat di legend
                                fillStyle: chart.data.datasets[0].backgroundColor[index],
                                strokeStyle: chart.data.datasets[0].borderColor[index],
                                lineWidth: 1
                            });
                        });
                        return labels;
                    }
                }
            }
        },
        // Customize appearance of bars
        elements: {
            bar: {
                borderWidth: 1,
                borderColor: 'rgba(0,0,0,0.1)'
            }
        }
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
<?php
include('footer.php')
?>