```
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
```
