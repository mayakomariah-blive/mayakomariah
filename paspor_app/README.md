# Aplikasi Pengajuan Paspor - Kantor Imigrasi Cabang

Aplikasi sederhana menggunakan PHP native + MySQL sesuai soal UAS Pemrograman Web II.

## Fitur yang diimplementasikan
1. **Daftar** — Input pendaftaran, otomatis menentukan hari & tanggal harus datang
   berdasarkan kuota maksimal 5 pendaftar per hari (jika penuh, otomatis maju ke hari berikutnya).
2. **Daftar Ulang** — Input kelengkapan berkas (KTP/KK/Ijazah-Akta) dan tanggal kedatangan.
   Jika berkas lengkap DAN tanggal datang sesuai jadwal → keterangan "OK" dan mendapat
   nomor antrian otomatis (auto increment). Jika tidak → keterangan "tidak".
3. **Pengurusan** — Memproses data yang keterangannya OK. Jika KTP, KK, dan Ijazah/Akta
   semua ada → berkas "Lengkap", status "Diterima", keterangan "OK", pembayaran otomatis
   Rp355.000. Jika tidak lengkap → status "Pelanggan" (harus melengkapi), pembayaran 0.
   Total pendapatan dihitung otomatis dari status "Diterima".

## Cara Menjalankan (XAMPP/Laragon)
1. Copy folder `paspor_app` ke folder `htdocs` (XAMPP) atau `www` (Laragon).
2. Buka phpMyAdmin, import file `db_paspor.sql` (akan otomatis membuat database `db_paspor`
   beserta 3 tabel: `tbl_daftar`, `tbl_daftar_ulang`, `tbl_pengurusan`).
3. Sesuaikan `koneksi.php` jika perlu (default: host=localhost, user=root, password kosong).
4. Akses melalui browser: `http://localhost/paspor_app/daftar.php`

## Alur penggunaan
1. Buka menu **Daftar** → isi nama pemohon & tanggal daftar → Simpan.
   Sistem otomatis menghitung hari/tanggal harus datang.
2. Buka menu **Daftar Ulang** → pilih No. Daftar yang sudah dibuat → isi hari/tgl datang
   dan centang berkas yang dimiliki → Simpan. Jika sesuai ketentuan akan langsung
   mendapat No. Antrian.
3. Buka menu **Pengurusan** → pilih No. Antrian yang berstatus OK → klik Proses.
   Sistem otomatis menentukan status, keterangan, dan pembayaran.

## Struktur File
```
paspor_app/
├── koneksi.php          # koneksi database
├── db_paspor.sql        # script SQL (import ke phpMyAdmin)
├── daftar.php           # menu 1: Daftar
├── daftar_ulang.php     # menu 2: Daftar Ulang
├── pengurusan.php       # menu 3: Pengurusan
└── includes/
    └── header.php       # navigasi & style bersama
```
