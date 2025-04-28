<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Judul halaman yang akan muncul di tab browser -->
    <title>Login Tugas</title>
</head>

<body>

    <!-- Judul sambutan saat pengguna membuka halaman login -->
    <h4>Selamat datang di Tugas!</h4>

    <!-- Kalimat penjelas singkat mengenai tujuan halaman -->
    <p>Silahkan masuk dan mulailah bekerja</p>

    <!-- 
        Bagian untuk menampilkan pesan kesalahan jika login gagal.
        Pesan ini akan muncul jika terdapat flashdata 'error' dari session.
    -->
    <?php if (session()->getFlashdata('error')): ?>
        <p><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <!-- 
        Formulir login. Pengguna akan mengisi username dan password,
        lalu data dikirimkan ke URL '/proses-login' menggunakan metode POST.
    -->
    <form action="<?= base_url('/proses-login') ?>" method="post">

        <!-- Input untuk username -->
        <div>
            <label for="nama">Username</label>
            <!-- 
                Input tipe teks untuk nama pengguna. 
                name="nama" untuk mengambil datanya di backend.
            -->
            <input type="text" id="nama" name="nama" placeholder="Masukkan username" />
        </div>

        <!-- Input untuk password -->
        <div>
            <label for="password">Password</label>
            <!-- 
                Input tipe password agar karakter yang diketik tidak terlihat. 
                name="password" untuk mengambil datanya di backend.
            -->
            <input type="password" id="password" name="password" placeholder="Password" />
        </div>

        <!-- Tombol untuk mengirimkan form login -->
        <div>
            <button type="submit">Masuk</button>
        </div>
    </form>

    <!-- 
        Link ke halaman pendaftaran.
        Digunakan jika pengguna belum memiliki akun.
    -->
    <p>
        <span>Belum memiliki akun?</span>
        <a href="<?= site_url('user/create') ?>">Buat Akun</a>
    </p>

</body>

</html>