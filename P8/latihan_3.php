<?php
// Fungsi repeat dengan default value pada parameter $num yaitu 10 [cite: 111]
function repeat($text, $num = 10)
{
    echo "<ol>\r\n";
    for($i = 0; $i < $num; $i++) // Melakukan perulangan sebanyak $num [cite: 114]
    {
        echo "<li>$text </li>\r\n"; [cite: 116]
    }
    echo "</ol>";
}

// Memanggil fungsi dengan dua argumen (teks dan jumlah perulangan 15) [cite: 121]
echo "<strong>Panggilan dengan 2 argumen (15 kali):</strong>";
repeat("I'm the best", 15);

// Memanggil fungsi dengan satu argumen (menggunakan default 10 kali) [cite: 123]
echo "<strong>Panggilan dengan 1 argumen (default 10 kali):</strong>";
repeat("You're the man");
?>