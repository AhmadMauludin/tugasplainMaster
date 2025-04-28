<?php
// Mengambil ID user yang sedang login dari session
$idu = session('id');
?>

<!-- Menu navigasi dalam bentuk daftar tidak bernomor -->
<ul>

    <!-- Menu menuju halaman dashboard -->
    <li>
        <a href="<?= base_url('/dashboard') ?>">Dashboard</a>
    </li>

    <!-- Jika user yang login adalah admin -->
    <?php if (session()->get('bagian') == "admin"): ?>
        <li>
            <a href="<?= site_url('user/') ?>">User</a>
        </li>
    <?php endif; ?>

    <!-- Jika user yang login adalah user biasa -->
    <?php if (session()->get('bagian') == "user"): ?>
        <li>
            <a href="<?= site_url('tugas/create') ?>">Tugas Baru</a>
        </li>

        <li>
            <a href="<?= site_url('tugas/sharedtome') ?>">Tugas</a>
        </li>

        <li>
            <a href="<?= site_url('/groups') ?>">Groups</a>
        </li>

        <li>
            <a href="<?= site_url('/friendship') ?>">Friendship</a>
        </li>
    <?php endif; ?>

    <!-- Menu untuk melakukan backup database -->
    <li>
        <a href="<?= site_url('/backup') ?>">Backup DB</a>
    </li>

    <!-- Menu untuk mengatur profil user -->
    <li>
        <a href="<?= site_url('user/edit/' . $idu) ?>">Pengaturan</a>
    </li>

    <!-- Menu logout untuk keluar dari aplikasi -->
    <li>
        <a href="<?= site_url('/logout') ?>">Logout</a>
    </li>

</ul>