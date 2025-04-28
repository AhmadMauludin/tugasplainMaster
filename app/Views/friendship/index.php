<!-- Memanggil template utama dari folder layouts dengan nama main -->
<?= $this->extend('layouts/main') ?>

<!-- Membuka bagian konten yang akan diisi ke dalam template -->
<?= $this->section('content') ?>

<!-- ==================== FORM TAMBAH TEMAN ==================== -->

<!-- Judul bagian -->
<h3>Tambah Teman</h3>

<!-- 
    Formulir untuk menambahkan teman baru.
    Data dikirim ke URL friendship/add menggunakan metode POST.
    Input yang dimasukkan adalah ID user teman.
-->
<form action="<?= site_url('friendship/add') ?>" method="POST">
    <!-- 
        Input teks untuk memasukkan ID teman.
        Atribut "required" memastikan input tidak boleh kosong saat disubmit.
    -->
    <input type="text" name="friend_id" required placeholder="Masukkan ID User Teman">

    <!-- Tombol untuk submit form -->
    <button type="submit">Tambah</button>
</form>

<br>

<!-- ==================== NOTIFIKASI FLASH MESSAGE ==================== -->

<!-- 
    Perulangan untuk mengecek apakah ada pesan flash dari session 
    dengan tipe 'success', 'error', atau 'info'.
-->
<?php foreach (['success', 'error', 'info'] as $type): ?>
    <!-- 
        Cek apakah ada flashdata dari session dengan tipe saat ini 
        (misalnya session()->getFlashdata('success'))
    -->
    <?php if (session()->getFlashdata($type)): ?>
        <!-- Menampilkan pesan notifikasi sesuai tipe -->
        <div>
            <?= session()->getFlashdata($type) ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<br>

<!-- ==================== DAFTAR TEMAN ==================== -->

<h3>Teman Anda</h3>

<!-- 
    Tabel untuk menampilkan daftar teman.
    Terdiri dari kolom: Foto, Nama, dan Aksi.
-->
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Foto</th>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <!-- 
            Perulangan untuk menampilkan setiap data teman yang ada 
            di variabel $friends. 
            $friend adalah nama variabel sementara untuk setiap elemen.
        -->
        <?php foreach ($friends as $friend): ?>
            <tr>
                <!-- Menampilkan foto teman -->
                <td>
                    <!-- 
                        Menampilkan gambar berdasarkan path dari direktori uploads/user.
                        Jika tidak ada foto, akan menggunakan 'default.jpg' sebagai foto bawaan.
                    -->
                    <img src="<?= base_url('uploads/user/' . ($friend['foto'] ?? 'default.jpg')) ?>" alt="Foto" height="40">
                </td>

                <!-- Menampilkan nama teman dengan fungsi esc() untuk keamanan (mencegah XSS) -->
                <td><?= esc($friend['nama']) ?></td>

                <!-- Menampilkan tombol untuk menghapus pertemanan -->
                <td>
                    <a href="<?= site_url('friendship/remove/' . $friend['id']) ?>">Hapus Pertemanan</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br>

<!-- ==================== PERMINTAAN PERTEMANAN MASUK ==================== -->

<!-- 
    Mengecek apakah ada data permintaan pertemanan yang masuk.
    Jika variabel $friendRequests tidak kosong, maka tampilkan.
-->
<?php if (!empty($friendRequests)): ?>
    <h3>Permintaan Pertemanan</h3>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- 
                Menampilkan setiap permintaan pertemanan dari variabel $friendRequests.
                $request adalah variabel sementara untuk masing-masing permintaan.
            -->
            <?php foreach ($friendRequests as $request): ?>
                <tr>
                    <!-- Menampilkan foto pengirim permintaan -->
                    <td>
                        <img src="<?= base_url('uploads/user/' . ($request['foto'] ?? 'default.jpg')) ?>" height="40">
                    </td>

                    <!-- Menampilkan nama pengirim permintaan -->
                    <td><?= esc($request['nama']) ?></td>

                    <!-- Tombol untuk menerima atau menolak permintaan -->
                    <td>
                        <a href="<?= site_url('friendship/accept/' . $request['id']) ?>">Terima</a> |
                        <a href="<?= site_url('friendship/decline/' . $request['id']) ?>">Tolak</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<br>

<!-- ==================== PERMINTAAN PERTEMANAN TERKIRIM ==================== -->

<!-- 
    Mengecek apakah ada permintaan pertemanan yang sudah dikirim.
    Jika variabel $sentRequests tidak kosong, maka tampilkan.
-->
<?php if (!empty($sentRequests)): ?>
    <h3>Permintaan Terkirim</h3>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nama</th>
            </tr>
        </thead>
        <tbody>
            <!-- 
                Menampilkan setiap permintaan terkirim dari variabel $sentRequests.
                $sent adalah variabel sementara untuk masing-masing data.
            -->
            <?php foreach ($sentRequests as $sent): ?>
                <tr>
                    <!-- Menampilkan foto pengguna yang dikirimi permintaan -->
                    <td>
                        <img src="<?= base_url('uploads/user/' . ($sent['foto'] ?? 'default.jpg')) ?>" height="40">
                    </td>

                    <!-- Menampilkan nama pengguna -->
                    <td><?= esc($sent['nama']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<!-- Menutup bagian konten -->
<?= $this->endSection() ?>