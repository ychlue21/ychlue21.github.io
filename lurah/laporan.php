<?php
include ('header.php');
?>
<main class="content">
    <div>
        <!-- Form untuk memilih bulan dan tahun -->
        <div class="container">
            <h2>Generate Laporan Perbulan</h2>
            <form action="generatelaporan.php" method="GET">
                <div class="form-group">
                    <label for="bulan">Pilih Bulan:</label>
                    <select class="form-control" id="bulan" name="bulan">
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tahun">Pilih Tahun:</label>
                    <select class="form-control" id="tahun" name="tahun">
                        <?php 
                $currentYear = date("Y");
                for ($i = $currentYear; $i >= 2000; $i--) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
                    </select>
                </div>
                <br>


                <button type="submit" class="btn btn-success">Generate Laporan</button>
            </form>
        </div>

    </div>
</main>