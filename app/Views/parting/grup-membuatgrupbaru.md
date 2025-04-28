```
<!-- ===================== FORM TAMBAH GRUP ===================== -->

<!--
    Form untuk membuat grup baru.
    Data dikirim ke URL 'groups/store' menggunakan metode POST.
    enctype="multipart/form-data" digunakan karena ada upload file (foto).
-->
<form action="<?= site_url('groups/store') ?>" method="post" enctype="multipart/form-data">

    <!--
        Input tersembunyi untuk mengirimkan ID user yang sedang login.
        Nilainya diambil dari session dengan key 'id'.
    -->
    <input name="idu" type="hidden" value="<?= session()->get('id') ?>" required />

    <br>

    <!-- ===================== INPUT NAMA GRUP ===================== -->
    <!-- Label untuk input nama grup -->
    <label for="groupname">Nama Grup</label><br>

    <!-- Input teks untuk mengisi nama grup -->
    <input name="groupname" type="text" id="groupname" required />

    <br><br>

    <!-- ===================== INPUT DESKRIPSI ===================== -->
    <!-- Label untuk input deskripsi grup -->
    <label for="description">Deskripsi</label><br>

    <!-- Textarea untuk menuliskan deskripsi grup -->
    <textarea name="description" id="description" rows="3"></textarea>

    <br><br>

    <!-- ===================== INPUT FOTO GRUP ===================== -->
    <!-- Label untuk input unggah foto -->
    <label for="photo">Foto Grup</label><br>

    <!-- Input file untuk mengunggah foto grup -->
    <input name="photo" type="file" id="photo" />

    <br><br>

    <!-- ===================== TOMBOL ARAHAN DAN SUBMIT ===================== -->

    <!--
        Tombol untuk kembali ke halaman daftar grup.
        Menggunakan base_url untuk membentuk URL lengkap.
    -->
    <a href="<?= base_url('groups'); ?>">Kembali</a>

    <!-- Tombol untuk mengirimkan form -->
    <button type="submit">Tambah Grup</button>

</form>
```
