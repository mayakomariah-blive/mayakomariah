<?php
// Nama peralatan
$brg1 = "Buku"; $brg2 = "Mouse"; $brg3 = "FlashDisk"; $brg4 = "Pulpen";

// Harga satuan
$harga1 = 17500; $harga2 = 30000; $harga3 = 70000; $harga4 = 22300;

// Jumlah barang
$jmlbrg1 = 2; $jmlbrg2 = 5; $jmlbrg3 = 1; $jmlbrg4 = 3;

// Total harga per jenis
$th1 = $jmlbrg1 * $harga1;
$th2 = $jmlbrg2 * $harga2;
$th3 = $jmlbrg3 * $harga3;
$th4 = $jmlbrg4 * $harga4;

// Grand total
$tharga = $th1 + $th2 + $th3 + $th4;

// Diskon
$diskon = 5;
$tdiskon = ($diskon * $tharga)/100;

// Jumlah dibayar
$tdibayar = $tharga - $tdiskon;
?>