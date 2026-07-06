-- ==========================================
-- DATABASE: db_paspor
-- Sistem Pengajuan Paspor - Kantor Imigrasi Cabang
-- ==========================================

CREATE DATABASE IF NOT EXISTS db_paspor;
USE db_paspor;

-- 1. Tabel Pendaftaran (Menu: Daftar)
CREATE TABLE tbl_daftar (
    no_daftar INT AUTO_INCREMENT PRIMARY KEY,
    nama_pemohon VARCHAR(100) NOT NULL,
    tgl_daftar DATE NOT NULL,
    hari VARCHAR(20),
    tanggal DATE,      -- hari & tanggal harus datang (hasil perhitungan kuota)
    jam TIME
);

-- 2. Tabel Daftar Ulang (Menu: Daftar Ulang)
CREATE TABLE tbl_daftar_ulang (
    no_antrian INT AUTO_INCREMENT PRIMARY KEY,
    no_daftar INT NOT NULL,
    nama_pemohon VARCHAR(100),
    hari_harus_datang VARCHAR(20),
    tgl_harus_datang DATE,
    hari_datang VARCHAR(20),
    tgl_datang DATE,
    ktp ENUM('Ada','Tidak') DEFAULT 'Tidak',
    kk ENUM('Ada','Tidak') DEFAULT 'Tidak',
    ijazah_akta ENUM('Ada','Tidak') DEFAULT 'Tidak',
    keperluan VARCHAR(50),
    keterangan VARCHAR(20),  -- OK / Tidak
    FOREIGN KEY (no_daftar) REFERENCES tbl_daftar(no_daftar)
);

-- 3. Tabel Pengurusan Paspor (Menu: Pengurusan)
CREATE TABLE tbl_pengurusan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_antrian INT NOT NULL,
    no_daftar INT NOT NULL,
    nama_pemohon VARCHAR(100),
    berkas VARCHAR(20),      -- Lengkap / Tidak Lengkap
    status VARCHAR(20),      -- Diterima / Pelanggan
    keterangan VARCHAR(20),  -- OK
    pembayaran INT DEFAULT 0,
    FOREIGN KEY (no_antrian) REFERENCES tbl_daftar_ulang(no_antrian)
);
