<?php
$A = 123; // variabel global
function Test() {
    global $A; // mengambil variabel global A
    echo "Nilai A dalam fungsi = $A \n";
}
Test();
echo "Nilai A luar fungsi = $A \n";
?>