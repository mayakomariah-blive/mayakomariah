<?php
// Ambil data dari form
$nim     = $_POST['nim'] ?? '';
$nama    = $_POST['nama'] ?? '';
$jurusan = $_POST['jurusan'] ?? '';
$alamat  = $_POST['alamat'] ?? '';
$telp    = $_POST['telp'] ?? '';

// Tampilkan hasil
echo "<h2>Data Mahasiswa</h2>";
echo "<p><strong>NIM:</strong> {$nim}</p>";
echo "<p><strong>Nama:</strong> {$nama}</p>";
echo "<p><strong>Jurusan:</strong> {$jurusan}</p>";
echo "<p><strong>Alamat:</strong> {$alamat}</p>";
echo "<p><strong>No. Telp:</strong> {$telp}</p>";
// p13 - maya komariah 221011400527 
?>