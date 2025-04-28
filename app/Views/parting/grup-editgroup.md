```
<!-- Kontainer utama untuk form ubah data grup -->
<div>

    <?php if ($groups['photo']): ?>
        <!-- Jika grup memiliki foto, maka tampilkan foto tersebut -->
        <div>
            <img src="<?= base_url('uploads/groups/' . $groups['photo']) ?>" width="50" alt="Foto Grup">
        </div>
        <br>
    <?php endif; ?>

    <!-- Form untuk mengirim data update grup -->
    <form action="<?= site_url('groups/update/' . $groups['id']) ?>" method="post" enctype="multipart/form-data">
        <!-- Input tersembunyi untuk menyimpan nama file foto lama, agar bisa dihapus jika diganti -->
        <input type="hidden" name="old_foto" value="<?= $groups['photo'] ?>">

        <!-- ====================== INPUT NAMA GRUP ====================== -->
        <label for="groupname">Nama Grup</label><br>
        <!-- Input teks untuk mengisi atau mengubah nama grup -->
        <input type="text" name="groupname" id="groupname" value="<?= $groups['groupname'] ?>" required><br><br>

        <!-- ====================== INPUT DESKRIPSI ====================== -->
        <label for="description">Deskripsi</label><br>
        <!-- Textarea untuk mengisi deskripsi grup -->
        <textarea name="description" id="description" rows="3"><?= $groups['description'] ?></textarea><br><br>

        <!-- ====================== INPUT FOTO GRUP BARU ====================== -->
        <label for="photo">Foto Grup</label><br>
        <!-- Input file untuk mengunggah foto grup baru (jika ingin mengganti) -->
        <input type="file" name="photo" id="photo"><br><br>

        <!-- ====================== INPUT PASSWORD BARU + TOMBOL GENERATE ====================== -->
        <label for="password">Password Baru</label><br>
        <!-- Input untuk password baru, hanya bisa diisi dengan tombol generate -->
        <input type="text" name="password" id="password" readonly placeholder="<?= $groups['password'] ?>">
        <!-- Tombol untuk memicu fungsi generate password secara otomatis -->
        <button type="button" id="btnGenerate">Generate</button><br><br>

        <!-- ====================== TOMBOL AKSI ====================== -->
        <!-- Tombol untuk kembali ke halaman daftar grup -->
        <a href="<?= base_url('groups'); ?>">Kembali</a>
        <!-- Tombol untuk mengirimkan form dan menyimpan perubahan -->
        <button type="submit">Ubah Grup</button>
    </form>
</div>

<!-- ====================== SCRIPT JAVASCRIPT ====================== -->
<script>
    /**
     * Fungsi generatePassword
     * Digunakan untuk membuat string acak sepanjang 8 karakter
     * Karakter terdiri dari huruf kecil dan huruf besar
     * @param {number} length - panjang password yang dihasilkan
     * @returns {string} password acak
     */
    function generatePassword(length = 8) {
        // Daftar karakter yang digunakan untuk membuat password
        let characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        let password = '';

        // Loop sebanyak panjang karakter yang diinginkan
        for (let i = 0; i < length; i++) {
            // Pilih karakter acak dari daftar karakter
            let randomIndex = Math.floor(Math.random() * characters.length);
            password += characters.charAt(randomIndex);
        }

        return password;
    }

    // Menambahkan event ketika tombol generate diklik
    document.getElementById('btnGenerate').addEventListener('click', function() {
        // Memanggil fungsi generatePassword dan menyimpannya ke dalam variabel
        let newPassword = generatePassword();
        // Menampilkan password baru ke dalam input readonly
        document.getElementById('password').value = newPassword;
    });
</script>
```
