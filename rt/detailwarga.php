<?php
include('header.php');
?>
<?php
$warga=mysqli_query($koneksi,"SELECT * from warga WHERE NIK='".$_GET['NIK']."'");
$p=mysqli_fetch_object($warga);
?>
<main class="content">
    <!-- <div class="container d-flex justify-content-center"> -->
    <div class="box"
        style="width: 100%; max-width: 800px; margin: auto; font-size: 20px; border: 1px; border-radius: 8px; padding: 20px;">
        <h2 class="title text-center" style="margin-top: 0;">Detail Data Warga</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="font-weight-bold">NIK</td>
                            <td><?= $p->NIK?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">NO KK</td>
                            <td><?= $p->NOKK ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Nama Lengkap</td>
                            <td><?= ucwords(strtolower($p->namalengkap)) ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Jenis Kelamin</td>
                            <td><?= $p->JK ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tempat, Tanggal Lahir</td>
                            <td><?= $p->tempat_lahir . ', ' . $p->tgl_Lahir ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Alamat</td>
                            <td><?= $p->alamat ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Agama</td>
                            <td><?= $p->agama ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Pekerjaan</td>
                            <td><?= $p->pekerjaan ?></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-outline-secondary mt-3"
                    onclick="window.location='warga.php'">Kembali</button>
        </form>


    </div>
    </div>
</main>
<?php
include('footer.php');
?>