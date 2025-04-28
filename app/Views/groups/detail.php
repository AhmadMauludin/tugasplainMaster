<!-- Menggunakan layout utama dari layouts/main -->
<?= $this->extend('layouts/main'); ?>

<!-- Membuka section 'content' -->
<?= $this->section('content'); ?>

<!-- ===================== DETAIL GRUP ===================== -->

<!-- Menampilkan foto grup -->
<img src="<?= base_url('uploads/groups/' . $groups['photo']) ?>" height="100" alt="Foto Grup"><br><br>

<!-- Menampilkan informasi detail grup -->
<p><b>Kode Grup:</b> <?= $groups['id'] ?></p>
<p><b>Nama Grup:</b> <?= $groups['groupname'] ?></p>
<p><b>Deskripsi:</b> <?= $groups['description'] ?></p>
<p><b>Dibuat oleh:</b> <?= $groups['nama'] ?></p>
<p><b>Tanggal Dibuat:</b> <?= $groups['createddate'] ?></p>

<br>

<!-- ===================== DAFTAR MEMBER GRUP ===================== -->

<!-- Header daftar member -->
<p><b>Member Grup:</b></p>

<!-- Membuat nomor urut -->
<?php $no = 1; ?>

<!-- Perulangan untuk menampilkan data setiap member -->
<?php foreach ($member as $member): ?>
    <hr>
    <p><b>No:</b> <?= $no++ ?></p>
    <p><b>Nama:</b> <?= $member['nama'] ?></p>
    <p><b>Level:</b> <?= $member['memberlevel'] ?></p>
    <p><b>Foto:</b><br>
        <img src="<?= base_url('uploads/user/' . $member['foto']) ?>" height="40" alt="Foto User">
    </p>

    <!-- 
        Jika user yang login adalah admin grup, tampilkan tombol hapus member.
        $isAdmin adalah variabel boolean penentu status admin grup.
    -->
    <?php if ($isAdmin): ?>
        <form action="<?= base_url('groups/removeMember/' . $member['id']) ?>" method="post">
            <button type="submit" onclick="return confirm('Hapus member ini?')">Hapus Member</button>
        </form>
    <?php endif; ?>
<?php endforeach; ?>

<br>

<!-- ===================== FORM TAMBAH MEMBER ===================== -->

<!-- Jika user adalah admin, maka bisa menambah member baru -->
<?php if ($isAdmin): ?>
    <p><b>Tambah Member Baru:</b></p>

    <!-- Form tambah member -->
    <form action="<?= base_url('groups/addMember') ?>" method="post">

        <!-- Menyisipkan ID grup ke form -->
        <input type="hidden" name="idgroups" value="<?= $groups['id'] ?>">

        <!-- Dropdown untuk memilih user -->
        <label for="iduser">Pilih User:</label><br>
        <select name="iduser" id="iduser" required>
            <option value="">--Pilih--</option>
            <?php foreach ($user as $user): ?>
                <option value="<?= $user['id'] ?>"><?= $user['nama'] ?></option>
            <?php endforeach; ?>
        </select>

        <br><br>

        <!-- Dropdown untuk memilih level keanggotaan -->
        <label for="memberlevel">Level Member:</label><br>
        <select name="memberlevel" id="memberlevel" required>
            <option value="">--Pilih--</option>
            <option value="member">member</option>
            <option value="admin">admin</option>
        </select>

        <br>

        <!-- Tombol untuk submit form tambah member -->
        <button type="submit">Tambahkan Member</button>
    </form>
<?php endif; ?>

<!-- ===================== TOMBOL KEMBALI ===================== -->

<br>
<a href="<?= base_url('groups'); ?>">Kembali</a>

<!-- Menutup section content -->
<?= $this->endSection(); ?>