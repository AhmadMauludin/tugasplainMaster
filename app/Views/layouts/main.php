<!DOCTYPE html>
<html lang="en" dir="ltr">

<!-- Menyertakan file CSS utama (disesuaikan dengan template css masing masing) -->
<link rel="stylesheet" href="<?= base_url('assets/css/app.css'); ?>">

<head>
    <!-- Mendefinisikan karakter set halaman -->
    <meta charset="utf-8" />

    <!-- Mengatur tampilan halaman agar responsif di berbagai perangkat -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <!-- Judul halaman dinamis sesuai dengan variabel $title -->
    <title><?= $title; ?></title>

    <!-- Deskripsi halaman untuk SEO (kosong di sini) -->
    <meta name="description" content="" />

    <!-- Menyertakan favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon/favicon.ico'); ?>" />

    <!-- Menghubungkan ke font dari Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Menyertakan file CSS dari berbagai vendor dan pustaka (disesuaikan dengan template masing masing) -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/boxicons.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css'); ?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css'); ?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/apex-charts/apex-charts.css'); ?>" />

    <!-- Menyertakan file JavaScript helper (disesuaikan dengan template masing masing)-->
    <script src="<?= base_url('assets/vendor/js/helpers.js'); ?>"></script>
    <script src="<?= base_url('assets/js/config.js'); ?>"></script>
</head>

<body>
    <!-- Memanggil id pegguna dari seeion yang nantinya disimpan pada variabel $idu yang nantinya digunakan pada bagian yang dibutuhkan -->
    <?php $idu = session('id'); // Menyimpan ID user dari sesi ke variabel $idu 
    ?>

    <!-- Wrapper utama dari layout -->
    <div>
        <!-- Menu samping -->
        <aside>
            <!-- Logo dan nama aplikasi -->
            <div>
                <a href="<?= site_url('/') ?>">
                    <img src="<?= base_url('assets/logo.png') ?>" height="50">
                    <span>Tugas</span>
                </a>
            </div>

            <!-- Menu navigasi disisipkan dari view terpisah -->
            <?= view('layouts/menu') ?>
        </aside>

        <!-- Halaman utama -->
        <div>
            <!-- Navbar atas -->
            <nav>
                <div>
                    <strong><?= $title; // Menampilkan judul halaman 
                            ?></strong>
                    <div>
                        Hii, <b><?= session()->get('nama') ?></b>
                        <a href="<?= site_url('user/edit/' . $idu) ?>">
                            <img src="<?= base_url('uploads/user/' . session()->get('foto')) ?>" height="35">
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Konten utama -->
            <div>
                <!-- Section konten diisi oleh bagian konten yang akan dirender -->
                <?= $this->renderSection('content'); ?>
            </div>
        </div>
    </div>

    <!-- Core JS yang diperlukan (disesuaikan dengan tempalte css masing masing) -->
    <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/popper/popper.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/js/bootstrap.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/js/menu.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/apex-charts/apexcharts.js'); ?>"></script>
    <script src="<?= base_url('assets/js/main.js'); ?>"></script>
    <script src="<?= base_url('assets/js/dashboards-analytics.js'); ?>"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>