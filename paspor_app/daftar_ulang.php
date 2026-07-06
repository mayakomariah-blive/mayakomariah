<?php
include 'koneksi.php';

// ==========================================
// PROSES SIMPAN DAFTAR ULANG
// ==========================================
if (isset($_POST['simpan'])) {
    $no_daftar = intval($_POST['no_daftar']);
    $hari_datang = $_POST['hari_datang'];
    $tgl_datang = $_POST['tgl_datang'];
    $ktp = isset($_POST['ktp']) ? 'Ada' : 'Tidak';
    $kk = isset($_POST['kk']) ? 'Ada' : 'Tidak';
    $ijazah = isset($_POST['ijazah_akta']) ? 'Ada' : 'Tidak';
    $keperluan = $_POST['keperluan'];

    // Ambil data pendaftar untuk cek kesesuaian hari & tanggal harus datang
    $q = mysqli_query($koneksi, "SELECT * FROM tbl_daftar WHERE no_daftar = $no_daftar");
    $daftar = mysqli_fetch_assoc($q);
    $nama = $daftar['nama_pemohon'];
    $hari_harus = $daftar['hari'];
    $tgl_harus = $daftar['tanggal'];

    // ==========================================
    // ATURAN KETERANGAN:
    // KTP, KK, Ijazah/Akta = Ada/Tidak,
    // dan hari & tanggal datang harus SESUAI dengan hari & tanggal harus datang.
    // Jika semua Ada DAN tanggal sesuai => keterangan "OK", selain itu "tidak"
    // ==========================================
    if ($ktp == 'Ada' && $kk == 'Ada' && $ijazah == 'Ada' && $tgl_datang == $tgl_harus) {
        $keterangan = "OK";
    } else {
        $keterangan = "tidak";
    }

    mysqli_query($koneksi, "INSERT INTO tbl_daftar_ulang
        (no_daftar, nama_pemohon, hari_harus_datang, tgl_harus_datang, hari_datang, tgl_datang, ktp, kk, ijazah_akta, keperluan, keterangan)
        VALUES ($no_daftar, '$nama', '$hari_harus', '$tgl_harus', '$hari_datang', '$tgl_datang', '$ktp', '$kk', '$ijazah', '$keperluan', '$keterangan')");

    header("Location: daftar_ulang.php");
    exit;
}

// HAPUS
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM tbl_daftar_ulang WHERE no_antrian = $id");
    header("Location: daftar_ulang.php");
    exit;
}

// AMBIL DATA UNTUK EDIT
$editData = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $q = mysqli_query($koneksi, "SELECT * FROM tbl_daftar_ulang WHERE no_antrian = $id");
    $editData = mysqli_fetch_assoc($q);
}

// UPDATE
if (isset($_POST['update'])) {
    $id = intval($_POST['no_antrian']);
    $hari_datang = $_POST['hari_datang'];
    $tgl_datang = $_POST['tgl_datang'];
    $ktp = isset($_POST['ktp']) ? 'Ada' : 'Tidak';
    $kk = isset($_POST['kk']) ? 'Ada' : 'Tidak';
    $ijazah = isset($_POST['ijazah_akta']) ? 'Ada' : 'Tidak';
    $keperluan = $_POST['keperluan'];

    $q = mysqli_query($koneksi, "SELECT * FROM tbl_daftar_ulang WHERE no_antrian = $id");
    $old = mysqli_fetch_assoc($q);
    $tgl_harus = $old['tgl_harus_datang'];

    if ($ktp == 'Ada' && $kk == 'Ada' && $ijazah == 'Ada' && $tgl_datang == $tgl_harus) {
        $keterangan = "OK";
    } else {
        $keterangan = "tidak";
    }

    mysqli_query($koneksi, "UPDATE tbl_daftar_ulang SET hari_datang='$hari_datang', tgl_datang='$tgl_datang',
        ktp='$ktp', kk='$kk', ijazah_akta='$ijazah', keperluan='$keperluan', keterangan='$keterangan'
        WHERE no_antrian=$id");
    header("Location: daftar_ulang.php");
    exit;
}

include 'includes/header.php';
?>

<h3>Input Daftar Ulang</h3>
<form class="form-input" method="POST">
    <?php if ($editData): ?>
        <input type="hidden" name="no_antrian" value="<?php echo $editData['no_antrian']; ?>">
        <label>No. Daftar</label>
        <input type="text" value="<?php echo $editData['no_daftar']; ?>" disabled><br>
        <label>Nama Pemohon</label>
        <input type="text" value="<?php echo $editData['nama_pemohon']; ?>" disabled><br>
        <label>Hari Harus Datang</label>
        <input type="text" value="<?php echo $editData['hari_harus_datang']; ?>" disabled><br>
        <label>Tgl Harus Datang</label>
        <input type="text" value="<?php echo $editData['tgl_harus_datang']; ?>" disabled><br>
    <?php else: ?>
        <label>No. Daftar</label>
        <select name="no_daftar" required>
            <option value="">-- pilih --</option>
            <?php
            $q = mysqli_query($koneksi, "SELECT * FROM tbl_daftar ORDER BY no_daftar DESC");
            while ($r = mysqli_fetch_assoc($q)) {
                echo "<option value='{$r['no_daftar']}'>{$r['no_daftar']} - {$r['nama_pemohon']} (harus datang: {$r['hari']}, {$r['tanggal']})</option>";
            }
            ?>
        </select><br>
    <?php endif; ?>

    <label>Hari Datang</label>
    <input type="text" name="hari_datang" placeholder="cth: Senin" required
        value="<?php echo $editData ? $editData['hari_datang'] : ''; ?>"><br>

    <label>Tgl Datang</label>
    <input type="date" name="tgl_datang" required
        value="<?php echo $editData ? $editData['tgl_datang'] : ''; ?>"><br>

    <label>Berkas</label>
    <input type="checkbox" name="ktp" <?php echo ($editData && $editData['ktp']=='Ada')?'checked':''; ?>> KTP
    <input type="checkbox" name="kk" <?php echo ($editData && $editData['kk']=='Ada')?'checked':''; ?>> KK
    <input type="checkbox" name="ijazah_akta" <?php echo ($editData && $editData['ijazah_akta']=='Ada')?'checked':''; ?>> Ijazah/Akta<br>

    <label>Keperluan</label>
    <select name="keperluan">
        <?php
        $opsi = ['Umum','Haji','Umroh','Kerja'];
        foreach ($opsi as $o) {
            $sel = ($editData && $editData['keperluan']==$o) ? 'selected' : '';
            echo "<option value='$o' $sel>$o</option>";
        }
        ?>
    </select><br>

    <button class="btn" type="submit" name="<?php echo $editData ? 'update' : 'simpan'; ?>">
        <?php echo $editData ? 'Update' : 'Simpan'; ?>
    </button>
</form>

<h3>Data Pendaftar Ulang</h3>
<table>
    <tr>
        <th>No. Daftar</th><th>Nama Pemohon</th><th>Keperluan</th><th>KTP</th><th>KK</th>
        <th>Ijazah/Akta</th><th>Keterangan</th><th>No. Antrian</th><th>Action</th>
    </tr>
    <?php
    $result = mysqli_query($koneksi, "SELECT * FROM tbl_daftar_ulang ORDER BY no_antrian DESC");
    while ($row = mysqli_fetch_assoc($result)) {
        // No antrian hanya ditampilkan jika keterangan OK
        $noAntrian = ($row['keterangan'] == 'OK') ? $row['no_antrian'] : '-';
        echo "<tr>
            <td>{$row['no_daftar']}</td>
            <td>{$row['nama_pemohon']}</td>
            <td>{$row['keperluan']}</td>
            <td>{$row['ktp']}</td>
            <td>{$row['kk']}</td>
            <td>{$row['ijazah_akta']}</td>
            <td>{$row['keterangan']}</td>
            <td>{$noAntrian}</td>
            <td class='action'>
                <a href='daftar_ulang.php?edit={$row['no_antrian']}'>edit</a>
                <a href='daftar_ulang.php?hapus={$row['no_antrian']}' onclick=\"return confirm('Hapus data ini?')\">Hapus</a>
            </td>
        </tr>";
    }
    ?>
</table>

</body>
</html>
