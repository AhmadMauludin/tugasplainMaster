<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Akun Baru</title>
</head>

<body>

    <h2 align="center">Daftar Akun Baru</h2>

    <!-- Menampilkan pesan error jika ada -->
    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <!-- Form pendaftaran akun baru -->
    <form action="<?= base_url('/user/store') ?>" method="post" enctype="multipart/form-data">

        <!-- Input Nama -->
        <p>
            <label for="nama">Nama:</label><br>
            <input type="text" id="nama" name="nama" required placeholder="Masukkan nama">
        </p>

        <!-- Input bagian (disembunyikan) -->
        <input type="hidden" name="bagian" value="user" required>

        <!-- Input Password -->
        <p>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required placeholder="Masukkan password">
        </p>

        <!-- Input Foto -->
        <p>
            <label for="foto">Foto:</label><br>
            <input type="file" id="foto" name="foto">
        </p>

        <!-- Tombol Submit -->
        <p>
            <button type="submit">Daftar</button>
        </p>
    </form>

    <!-- Link ke halaman login -->
    <p>Sudah punya akun? <a href="<?= site_url('/') ?>">Login di sini</a></p>

</body>

</html>