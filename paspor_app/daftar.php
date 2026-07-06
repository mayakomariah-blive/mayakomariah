<?php
include 'koneksi.php';

// ==========================================
// FUNGSI: Cari hari & tanggal harus datang
// Aturan: kapasitas 1 hari = 5 orang.
// Jika hari tsb sudah penuh (>=5), maju ke hari berikutnya, dst.
// ==========================================
function cariTanggalHarusDatang($koneksi, $tglMulai) {
    $tanggalCek = $tglMulai;
    while (true) {
        $q = mysqli_query($koneksi, "SELECT COUNT(*) as jumlah FROM tbl_daftar WHERE tanggal = '$tanggalCek'");
        $row = mysqli_fetch_assoc($q);
        if ($row['jumlah'] < 5) {
            break; // hari ini masih ada slot
        }
        // kalau penuh, tambah 1 hari
        $tanggalCek = date('Y-m-d', strtotime($tanggalCek . ' +1 day'));
    }
    return $tanggalCek;
}

$namaHari = ['Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu',
             'Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'];

// ==========================================
// PROSES SIMPAN
// ==========================================
if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_pemohon']);
    $tgl_daftar = $_POST['tgl_daftar'];

    // Cari hari & tanggal harus datang otomatis berdasarkan kuota
    $tanggalHarusDatang = cariTanggalHarusDatang($koneksi, $tgl_daftar);
    $hari = $namaHari[date('l', strtotime($tanggalHarusDatang))];
    $jam = "09:00:00"; // jam default kedatangan

    mysqli_query($koneksi, "INSERT INTO tbl_daftar (nama_pemohon, tgl_daftar, hari, tanggal, jam)
        VALUES ('$nama', '$tgl_daftar', '$hari', '$tanggalHarusDatang', '$jam')");

    header("Location: daftar.php");
    exit;
}

// PROSES HAPUS
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM tbl_daftar WHERE no_daftar = $id");
    header("Location: daftar.php");
    exit;
}

// AMBIL DATA UNTUK EDIT
$editData = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $q = mysqli_query($koneksi, "SELECT * FROM tbl_daftar WHERE no_daftar = $id");
    $editData = mysqli_fetch_assoc($q);
}

// PROSES UPDATE
if (isset($_POST['update'])) {
    $id = intval($_POST['no_daftar']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_pemohon']);
    $tgl_daftar = $_POST['tgl_daftar'];
    $tanggalHarusDatang = cariTanggalHarusDatang($koneksi, $tgl_daftar);
    $hari = $namaHari[date('l', strtotime($tanggalHarusDatang))];

    mysqli_query($koneksi, "UPDATE tbl_daftar SET nama_pemohon='$nama', tgl_daftar='$tgl_daftar',
        hari='$hari', tanggal='$tanggalHarusDatang' WHERE no_daftar=$id");
    header("Location: daftar.php");
    exit;
}

include 'includes/header.php';
?>

<h3>Input Pendaftaran</h3>
<form class="form-input" method="POST">
    <?php if ($editData): ?>
        <input type="hidden" name="no_daftar" value="<?php echo $editData['no_daftar']; ?>">
    <?php endif; ?>

    <label>Nama Pemohon</label>
    <input type="text" name="nama_pemohon" required
        value="<?php echo $editData ? $editData['nama_pemohon'] : ''; ?>"><br>

    <label>Tanggal Daftar</label>
    <input type="date" name="tgl_daftar" required
        value="<?php echo $editData ? $editData['tgl_daftar'] : date('Y-m-d'); ?>"><br>

    <button class="btn" type="submit" name="<?php echo $editData ? 'update' : 'simpan'; ?>">
        <?php echo $editData ? 'Update' : 'Simpan'; ?>
    </button>
</form>

<h3>Data Pendaftar</h3>
<table>
    <tr>
        <th>No. Daftar</th><th>Nama Pemohon</th><th>Tgl Daftar</th>
        <th>Hari</th><th>Tanggal</th><th>Jam</th><th>Action</th>
    </tr>
    <?php
    $result = mysqli_query($koneksi, "SELECT * FROM tbl_daftar ORDER BY no_daftar DESC");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$row['no_daftar']}</td>
            <td>{$row['nama_pemohon']}</td>
            <td>{$row['tgl_daftar']}</td>
            <td>{$row['hari']}</td>
            <td>{$row['tanggal']}</td>
            <td>{$row['jam']}</td>
            <td class='action'>
                <a href='daftar.php?edit={$row['no_daftar']}'>edit</a>
                <a href='daftar.php?hapus={$row['no_daftar']}' onclick=\"return confirm('Hapus data ini?')\">Hapus</a>
            </td>
        </tr>";
    }
    ?>
</table>

</body>
</html>
