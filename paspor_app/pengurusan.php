<?php
include 'koneksi.php';

// ==========================================
// PROSES SIMPAN PENGURUSAN
// ==========================================
if (isset($_POST['proses'])) {
    $no_antrian = intval($_POST['no_antrian']);

    // Ambil data daftar ulang terkait
    $q = mysqli_query($koneksi, "SELECT * FROM tbl_daftar_ulang WHERE no_antrian = $no_antrian");
    $du = mysqli_fetch_assoc($q);

    $no_daftar = $du['no_daftar'];
    $nama = $du['nama_pemohon'];

    // ==========================================
    // ATURAN:
    // - Jika KTP, KK, Ijazah/Akta semua ADA => berkas "Lengkap", status "Diterima", keterangan "OK", pembayaran = 355000
    // - Jika tidak lengkap => berkas "Tidak Lengkap", status "Pelanggan" (perlu melengkapi), keterangan "-", pembayaran = 0
    // ==========================================
    if ($du['ktp'] == 'Ada' && $du['kk'] == 'Ada' && $du['ijazah_akta'] == 'Ada') {
        $berkas = "Lengkap";
        $status = "Diterima";
        $keterangan = "OK";
        $pembayaran = 355000;
    } else {
        $berkas = "Tidak Lengkap";
        $status = "Pelanggan";
        $keterangan = "-";
        $pembayaran = 0;
    }

    // Cek apakah sudah pernah diproses sebelumnya
    $cek = mysqli_query($koneksi, "SELECT * FROM tbl_pengurusan WHERE no_antrian = $no_antrian");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($koneksi, "UPDATE tbl_pengurusan SET berkas='$berkas', status='$status',
            keterangan='$keterangan', pembayaran=$pembayaran WHERE no_antrian=$no_antrian");
    } else {
        mysqli_query($koneksi, "INSERT INTO tbl_pengurusan
            (no_antrian, no_daftar, nama_pemohon, berkas, status, keterangan, pembayaran)
            VALUES ($no_antrian, $no_daftar, '$nama', '$berkas', '$status', '$keterangan', $pembayaran)");
    }

    header("Location: pengurusan.php");
    exit;
}

// HAPUS
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM tbl_pengurusan WHERE id = $id");
    header("Location: pengurusan.php");
    exit;
}

include 'includes/header.php';

// Hitung total pendapatan (sum pembayaran yang statusnya Diterima)
$q = mysqli_query($koneksi, "SELECT SUM(pembayaran) as total FROM tbl_pengurusan WHERE status='Diterima'");
$totalRow = mysqli_fetch_assoc($q);
$pendapatan = $totalRow['total'] ? $totalRow['total'] : 0;
?>

<h3>Proses Pengurusan Berkas</h3>
<form class="form-input" method="POST">
    <label>Pilih No. Antrian</label>
    <select name="no_antrian" required>
        <option value="">-- pilih --</option>
        <?php
        // Hanya tampilkan yang keterangan-nya OK dari daftar ulang (sudah dapat antrian)
        $q = mysqli_query($koneksi, "SELECT * FROM tbl_daftar_ulang WHERE keterangan='OK' ORDER BY no_antrian DESC");
        while ($r = mysqli_fetch_assoc($q)) {
            echo "<option value='{$r['no_antrian']}'>{$r['no_antrian']} - {$r['nama_pemohon']}</option>";
        }
        ?>
    </select><br>
    <button class="btn" type="submit" name="proses">Proses</button>
</form>

<h3>Data Pengurusan Paspor</h3>
<table>
    <tr>
        <th>No. Antrian</th><th>No. Daftar</th><th>Nama Pemohon</th><th>Berkas</th>
        <th>Status</th><th>Keterangan</th><th>Pembayaran</th><th>Action</th>
    </tr>
    <?php
    $result = mysqli_query($koneksi, "SELECT * FROM tbl_pengurusan ORDER BY id DESC");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$row['no_antrian']}</td>
            <td>{$row['no_daftar']}</td>
            <td>{$row['nama_pemohon']}</td>
            <td>{$row['berkas']}</td>
            <td>{$row['status']}</td>
            <td>{$row['keterangan']}</td>
            <td>Rp " . number_format($row['pembayaran'],0,',','.') . "</td>
            <td class='action'>
                <a href='pengurusan.php?hapus={$row['id']}' onclick=\"return confirm('Hapus data ini?')\">Hapus</a>
            </td>
        </tr>";
    }
    ?>
</table>

<div class="container">
    <strong>Pendapatan: Rp <?php echo number_format($pendapatan,0,',','.'); ?></strong>
</div>

</body>
</html>
