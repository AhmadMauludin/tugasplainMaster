<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<!-- Meta tag untuk melakukan refresh halaman setiap 60 detik -->
<meta http-equiv="refresh" content="60">

<?php
// Menetapkan timezone Jakarta
date_default_timezone_set('Asia/Jakarta');

// Array yang berisi nama hari dalam bahasa Indonesia
$hari = [
    'Sunday'    => 'Minggu',
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu'
];

// Mengambil informasi tanggal dan waktu saat ini
$now = new DateTime();
$namaHari = $hari[$now->format('l')]; // Menyimpan nama hari saat ini dalam bahasa Indonesia
$tanggal = $now->format('d-m-Y'); // Menyimpan tanggal dalam format dd-mm-yyyy
$jam     = $now->format('H:i'); // Menyimpan jam dalam format hh:mm
?>

<!-- Menampilkan informasi hari, tanggal, dan waktu -->
<div>
    <H2>Hari <strong> <?= $namaHari ?></strong></H2> <!-- Menampilkan nama hari dalam bahasa Indonesia -->
    <?= $tanggal ?></p> <!-- Menampilkan tanggal -->
    <?= $jam ?> WIB</p> <!-- Menampilkan jam dalam format WIB -->
</div>

<!-- Menampilkan pesan error jika ada menggunakan session flashdata -->
<?php if (session()->getFlashdata('error')): ?>
    <p style="color:red"><?= session()->getFlashdata('error') ?></p>
<?php endif; ?>

<!-- Menampilkan daftar tugas baru -->
<?php foreach ($tugasBaru as $tugas): ?>
    <div>
        <!-- Menampilkan tugas baru yang belum diterima -->
        Tugas <strong><?= esc($tugas['tugas']) ?></strong> (<?= esc($tugas['status']) ?>) Ada tugas baru yang dibagikan kepada anda dan belum diterima!
        <!-- Link menuju detail tugas -->
        <a href="<?= base_url('tugas/detail/' . $tugas['id']) ?>">Detail</a>
    </div>
<?php endforeach; ?>

<!-- Menampilkan daftar tugas yang harus segera dikerjakan -->
<?php foreach ($tugasSegera as $tugas): ?>
    <div>
        <!-- Menampilkan tugas yang harus segera dikerjakan dalam waktu kurang dari 24 jam -->
        Tugas <strong><?= esc($tugas['tugas']) ?></strong> (<?= esc($tugas['status']) ?>) harus segera dikerjakan (kurang dari 24 jam)!
        <!-- Link menuju detail tugas -->
        <a href="<?= base_url('tugas/detail/' . $tugas['id']) ?>">Detail</a>
    </div>
<?php endforeach; ?>

<!-- Menampilkan daftar tugas yang sudah terlambat -->
<?php foreach ($tugasTerlambat as $tugas): ?>
    <div>
        <!-- Menampilkan tugas yang sudah melewati batas waktu -->
        Tugas <strong><?= esc($tugas['tugas']) ?></strong> (<?= esc($tugas['status']) ?>) sudah melewati batas waktu!
        <!-- Link menuju detail tugas -->
        <a href="<?= base_url('tugas/detail/' . $tugas['id']) ?>">Detail</a>
    </div>
<?php endforeach; ?>

<?= $this->endSection(); ?>