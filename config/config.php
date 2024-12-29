<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "sisurat";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if(!$koneksi){
    die("gagal terkoneksi");
}