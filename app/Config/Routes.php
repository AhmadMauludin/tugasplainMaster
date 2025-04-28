<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Variabel Filter
$authFilter = ['filter' => 'auth'];  // Menetapkan filter untuk memastikan hanya pengguna yang sudah terautentikasi yang bisa mengakses rute ini.

// Variabel Role
$admin     = ['filter' => 'role:admin'];  // Filter ini hanya memungkinkan pengguna dengan role 'admin' yang bisa mengakses rute ini.
$user      = ['filter' => 'role:user'];  // Filter ini hanya memungkinkan pengguna dengan role 'user' yang bisa mengakses rute ini.
$allRole    = ['filter' => 'role:admin,user'];  // Filter ini memperbolehkan pengguna dengan role 'admin' dan 'user' yang bisa mengakses rute ini.


// Backup db
$routes->get('/backup', 'Backup::database', $allRole);  // Rute GET untuk halaman backup, hanya bisa diakses oleh admin atau user.

// Login
$routes->get('/login', 'Auth::login');  // Rute GET untuk halaman login.
$routes->post('/proses-login', 'Auth::prosesLogin');  // Rute POST untuk memproses login.
$routes->get('/logout', 'Auth::logout');  // Rute GET untuk logout.

// Halaman utama
$routes->get('/', 'Home::index', $authFilter);  // Rute GET untuk halaman utama, hanya bisa diakses oleh pengguna yang terautentikasi.
$routes->get('/dashboard', 'Home::index', $authFilter);  // Rute GET untuk dashboard, hanya bisa diakses oleh pengguna yang terautentikasi.

// tugas
$routes->get('tugas/index1', 'tugas::index1', $user);  // Rute GET untuk melihat semua tugas.
$routes->get('tugas/create', 'tugas::create', $user);  // Rute GET untuk membuat tugas baru, hanya bisa diakses oleh user.
$routes->post('tugas/store', 'tugas::store', $user);  // Rute POST untuk menyimpan tugas baru.
$routes->get('tugas/detail/(:num)', 'tugas::detail/$1', $user);  // Rute GET untuk melihat detail tugas berdasarkan ID yang diteruskan.
$routes->get('tugas/edit/(:num)', 'tugas::edit/$1', $user);  // Rute GET untuk mengedit tugas berdasarkan ID yang diteruskan.
$routes->post('tugas/update/(:num)', 'tugas::update/$1', $user);  // Rute POST untuk memperbarui tugas berdasarkan ID yang diteruskan.
$routes->get('tugas/delete/(:num)', 'tugas::delete/$1', $user);  // Rute GET untuk menghapus tugas berdasarkan ID yang diteruskan.
$routes->get('tugas/sharedtome', 'tugas::sharedToMe', $user);  // Rute GET untuk melihat tugas yang dibagikan kepada pengguna.
$routes->get('tugas/selesai/(:num)', 'Tugas::selesai/$1', $user);  // Rute GET untuk menandai tugas selesai berdasarkan ID yang diteruskan.

//shared
$routes->post('/shared/store', 'shared::store', $user);  // Rute POST untuk menyimpan data yang dibagikan.
$routes->post('/shared/delete/(:num)', 'shared::delete/$1', $user);  // Rute POST untuk menghapus data yang dibagikan berdasarkan ID yang diteruskan.
$routes->post('shared/shareToGroup/(:num)', 'shared::shareToGroup/$1', $user);  // Rute POST untuk membagikan data ke grup berdasarkan ID yang diteruskan.
$routes->get('shared/updateStatusNext/(:num)', 'shared::updateStatusNext/$1', $user);  // Rute GET untuk memperbarui status berbagi ke status berikutnya berdasarkan ID yang diteruskan.

// attachment
$routes->get('attachment', 'attachment::index', $user);  // Rute GET untuk melihat daftar lampiran, hanya bisa diakses oleh user.
$routes->get('attachment/create', 'attachment::create', $user);  // Rute GET untuk membuat lampiran baru, hanya bisa diakses oleh user.
$routes->post('attachment/store', 'attachment::store', $user);  // Rute POST untuk menyimpan lampiran baru.
$routes->get('attachment/edit/(:num)', 'attachment::edit/$1', $user);  // Rute GET untuk mengedit lampiran berdasarkan ID yang diteruskan.
$routes->post('attachment/update/(:num)', 'attachment::update/$1', $user);  // Rute POST untuk memperbarui lampiran berdasarkan ID yang diteruskan.
$routes->post('attachment/delete/(:num)', 'attachment::delete/$1', $user);  // Rute POST untuk menghapus lampiran berdasarkan ID yang diteruskan.

// user
$routes->get('user', 'User::index', $admin);  // Rute GET untuk melihat daftar pengguna, hanya bisa diakses oleh admin.
$routes->get('user/create', 'User::create');  // Rute GET untuk membuat pengguna baru.
$routes->post('user/store', 'User::store');  // Rute POST untuk menyimpan pengguna baru.
$routes->get('user/edit/(:num)', 'User::edit/$1', $allRole);  // Rute GET untuk mengedit pengguna berdasarkan ID yang diteruskan, bisa diakses oleh admin dan user.
$routes->post('user/update/(:num)', 'User::update/$1', $allRole);  // Rute POST untuk memperbarui pengguna berdasarkan ID yang diteruskan, bisa diakses oleh admin dan user.
$routes->get('user/delete/(:num)', 'User::delete/$1', $admin);  // Rute GET untuk menghapus pengguna berdasarkan ID yang diteruskan, hanya bisa diakses oleh admin.

// groups
$routes->get('groups', 'groups::index', $user);  // Rute GET untuk melihat daftar grup, hanya bisa diakses oleh user.
$routes->get('groups/create', 'groups::create', $user);  // Rute GET untuk membuat grup baru, hanya bisa diakses oleh user.
$routes->post('groups/store', 'groups::store', $user);  // Rute POST untuk menyimpan grup baru.
$routes->get('groups/edit/(:num)', 'groups::edit/$1', $user);  // Rute GET untuk mengedit grup berdasarkan ID yang diteruskan.
$routes->post('groups/update/(:num)', 'groups::update/$1', $user);  // Rute POST untuk memperbarui grup berdasarkan ID yang diteruskan.
$routes->get('groups/delete/(:num)', 'groups::delete/$1', $user);  // Rute GET untuk menghapus grup berdasarkan ID yang diteruskan.
$routes->get('groups/detail/(:num)', 'groups::detail/$1', $user);  // Rute GET untuk melihat detail grup berdasarkan ID yang diteruskan.
$routes->post('groups/addMember', 'groups::addMember', $user);  // Rute POST untuk menambahkan anggota ke grup.
$routes->post('groups/removeMember/(:num)', 'groups::removeMember/$1', $user);  // Rute POST untuk menghapus anggota dari grup berdasarkan ID anggota yang diteruskan.

// friendship
$routes->get('/friendship', 'Friendship::index', $user);  // Rute GET untuk melihat daftar pertemanan, hanya bisa diakses oleh user.
$routes->get('friendship/index', 'Friendship::index', $user);  // Rute GET untuk melihat daftar pertemanan, hanya bisa diakses oleh user.
$routes->post('friendship/add', 'Friendship::add', $user);  // Rute POST untuk menambah pertemanan.
$routes->get('friendship/accept/(:num)', 'Friendship::accept/$1', $user);  // Rute GET untuk menerima pertemanan berdasarkan ID yang diteruskan.
$routes->get('friendship/decline/(:num)', 'Friendship::decline/$1', $user);  // Rute GET untuk menolak pertemanan berdasarkan ID yang diteruskan.
$routes->get('friendship/remove/(:num)', 'Friendship::remove/$1', $user);  // Rute GET untuk menghapus pertemanan berdasarkan ID yang diteruskan.

// if this line is still there, it means I just copy paste my friend's UKK application
