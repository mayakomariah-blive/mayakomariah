<?php
mysql_connect("localhost","root","");
mysql_select_db("db_bukutamu");

// Mengambil data dengan limit 5 record sesuai soal[cite: 2]
$hasil = mysql_query("SELECT * FROM tbl_bukutamu LIMIT 5");

// Mengetahui jumlah record saat ini[cite: 2]
$jumlah = mysql_num_rows($hasil);
echo "Menampilkan $jumlah record terbaru:<br><hr>";

// Menampilkan data per record menggunakan nama field[cite: 2]
while($data = mysql_fetch_array($hasil)) {
    echo "ID: $data[id] <br>";
    echo "Nama: $data[nama] <br>";
    echo "Email: $data[email] <br>";
    echo "Pesan: $data[pesan] <hr>";
}
?>