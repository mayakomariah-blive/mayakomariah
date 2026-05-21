<html>
<head><title>Contoh Penggunaan UDF</title></head>
<body>
    <form method="post">
        Masukkan Bilangan Pertama: <br>
        <input type="text" name="A" size="10"> <br>
        Masukkan Bilangan Kedua: <br>
        <input type="text" name="B" size="10"> <br>
        <input type="submit" value="hitung">
    </form>

<?php
if ($_POST) {
    // Mengambil data dari form [cite: 55, 56]
    $a = $_POST["A"];
    $b = $_POST["B"];

    // Fungsi Penjumlahan [cite: 57, 59]
    function jumlah($A, $B) {
        $jumlahbil = $A + $B;
        return $jumlahbil;
    }

    // Fungsi Pengurangan [cite: 61, 63]
    function kurang($A, $B) {
        $kurangbil = $A - $B;
        return $kurangbil;
    }

    // Fungsi Perkalian [cite: 66, 69]
    function kali($A, $B) {
        $kalibil = $A * $B;
        return $kalibil;
    }

    // Fungsi Pembagian [cite: 71, 74]
    function bagi($A, $B) {
        if ($B != 0) {
            $bagibil = $A / $B;
        } else {
            $bagibil = 0; // Menghindari error pembagian dengan nol
        }
        return $bagibil;
    }

    // Menampilkan Input [cite: 78, 81]
    echo "Bilangan Pertama : " . $a . "<br>";
    echo "Bilangan Kedua : " . $b . "<br><br>";

    // Menampilkan Hasil Penjumlahan [cite: 84, 87]
    $hasil_jumlah = jumlah($a, $b);
    printf("Hasil Penjumlahan antara : %d + %d = %d <br><br>", $a, $b, $hasil_jumlah);

    // Menampilkan Hasil Pengurangan [cite: 90, 93]
    $hasil_kurang = kurang($a, $b);
    printf("Hasil Pengurangan antara : %d - %d = %d <br><br>", $a, $b, $hasil_kurang);

    // Menampilkan Hasil Perkalian [cite: 95, 99]
    $hasil_kali = kali($a, $b);
    printf("Hasil Perkalian antara : %d * %d = %d <br><br>", $a, $b, $hasil_kali);

    // Menampilkan Hasil Pembagian [cite: 101, 104]
    $hasil_bagi = bagi($a, $b);
    printf("Hasil Pembagian antara : %d / %d = %d <br><br>", $a, $b, $hasil_bagi);
}
?>
</body>
</html>