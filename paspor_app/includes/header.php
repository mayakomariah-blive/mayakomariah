<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengajuan Paspor - Kantor Imigrasi Cabang</title>
<style>
    body { font-family: Arial, sans-serif; margin: 30px; background:#f4f4f4; }
    .header { text-align:left; margin-bottom:10px; }
    .header h2 { margin:0; }
    .nav a { margin-right: 15px; text-decoration: none; color: #0056b3; font-weight:bold; }
    .nav a.active { text-decoration: underline; color:#003366; }
    table { border-collapse: collapse; width: 100%; background:#fff; margin-top:10px; }
    th, td { border: 1px solid #999; padding: 6px 8px; text-align:center; font-size:14px; }
    th { background:#dbe9ff; }
    form.form-input { background:#fff; padding:15px; border:1px solid #ccc; width:400px; margin-top:10px; }
    form.form-input label { display:inline-block; width:150px; }
    form.form-input input, form.form-input select { width:200px; padding:4px; margin-bottom:8px; }
    .btn { padding:6px 14px; background:#0056b3; color:#fff; border:none; cursor:pointer; }
    .btn:hover { background:#003d80; }
    .action a { margin:0 4px; font-size:13px; }
    .container { background:#fff; padding:15px; border:1px solid #ccc; margin-top:10px; }
</style>
</head>
<body>

<div class="header">
    <strong>PENGAJUAN PASPOR</strong><br>
    Kantor Imigrasi Cabang<br><br>
    Programmer: [nama mahasiswa]
</div>

<div class="nav">
    <a href="daftar.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='daftar.php')?'active':''; ?>">Daftar</a>
    <a href="daftar_ulang.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='daftar_ulang.php')?'active':''; ?>">Daftar Ulang</a>
    <a href="pengurusan.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='pengurusan.php')?'active':''; ?>">Pengurusan</a>
</div>
<hr>
