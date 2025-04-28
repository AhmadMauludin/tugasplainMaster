```
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
```
