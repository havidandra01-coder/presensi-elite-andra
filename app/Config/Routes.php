<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('login', 'Login::login_action');
$routes->get('logout', 'Login::logout');

$routes->get('admin/home', 'Admin\Home::index', ['filter' => 'adminFilter']);
$routes->get('admin/jabatan', 'Admin\Jabatan::index', ['filter' => 'adminFilter']);
$routes->get('admin/jabatan/create', 'Admin\Jabatan::create', ['filter' => 'adminFilter']);
$routes->post('admin/jabatan/store', 'Admin\Jabatan::store', ['filter' => 'adminFilter']);
$routes->get('admin/jabatan/edit/(:segment)', 'Admin\Jabatan::edit/$1', ['filter' => 'adminFilter']);
$routes->post('admin/jabatan/update/(:segment)', 'Admin\Jabatan::update/$1', ['filter' => 'adminFilter']);
$routes->get('admin/jabatan/delete/(:segment)', 'Admin\Jabatan::delete/$1', ['filter' => 'adminFilter']);

$routes->get('admin/lokasi_presensi', 'Admin\LokasiPresensi::index', ['filter' => 'adminFilter']);
$routes->get('admin/lokasi_presensi/create', 'Admin\LokasiPresensi::create', ['filter' => 'adminFilter']);
$routes->post('admin/lokasi_presensi/store', 'Admin\LokasiPresensi::store', ['filter' => 'adminFilter']);
$routes->get('admin/lokasi_presensi/edit/(:segment)', 'Admin\LokasiPresensi::edit/$1', ['filter' => 'adminFilter']);
$routes->post('admin/lokasi_presensi/update/(:segment)', 'Admin\LokasiPresensi::update/$1', ['filter' => 'adminFilter']);
$routes->get('admin/lokasi_presensi/delete/(:segment)', 'Admin\LokasiPresensi::delete/$1', ['filter' => 'adminFilter']);
$routes->get('admin/lokasi_presensi/detail/(:segment)', 'Admin\LokasiPresensi::detail/$1', ['filter' => 'adminFilter']);

$routes->get('admin/data_siswa', 'Admin\DataSiswa::index', ['filter' => 'adminFilter']);
$routes->get('admin/data_siswa/create', 'Admin\DataSiswa::create', ['filter' => 'adminFilter']);
$routes->post('admin/data_siswa/store', 'Admin\DataSiswa::store', ['filter' => 'adminFilter']);
$routes->get('admin/data_siswa/edit/(:segment)', 'Admin\DataSiswa::edit/$1', ['filter' => 'adminFilter']);
$routes->post('admin/data_siswa/update/(:segment)', 'Admin\DataSiswa::update/$1', ['filter' => 'adminFilter']);
$routes->get('admin/data_siswa/delete/(:segment)', 'Admin\DataSiswa::delete/$1', ['filter' => 'adminFilter']);
$routes->get('admin/data_siswa/detail/(:segment)', 'Admin\DataSiswa::detail/$1', ['filter' => 'adminFilter']);

$routes->get('admin/rekap_harian', 'Admin\RekapPresensi::rekap_harian', ['filter' => 'adminFilter']);
$routes->get('admin/rekap_bulanan', 'Admin\RekapPresensi::rekap_bulanan', ['filter' => 'adminFilter']);

$routes->get('siswa/home', 'Siswa\Home::index', ['filter' => 'siswaFilter']);
$routes->post('siswa/presensi_masuk', 'Siswa\Home::presensi_masuk', ['filter' => 'siswaFilter']);
$routes->post('siswa/presensi_masuk_aksi', 'Siswa\Home::presensi_masuk_aksi', ['filter' => 'siswaFilter']);

$routes->post('siswa/presensi_keluar/(:segment)', 'Siswa\Home::presensi_keluar/$1', ['filter' => 'siswaFilter']);
$routes->post('siswa/presensi_keluar_aksi/(:segment)', 'Siswa\Home::presensi_keluar_aksi/$1', ['filter' => 'siswaFilter']);

$routes->get('siswa/rekap_presensi', 'Siswa\RekapPresensi::index', ['filter' => 'siswaFilter']);

// Tambahkan 'Siswa' di tengah namespace-nya
$routes->post('siswa/update_foto', '\App\Controllers\Siswa\Profil::update_foto');

$routes->get('admin/profil', 'Admin\Profil::index');
$routes->post('admin/update_foto', 'Admin\Profil::update_foto');


// Rute untuk Siswa (CRUD Ketidakhadiran)
$routes->group('siswa', ['filter' => 'siswaFilter'], function($routes) {
    $routes->get('ketidakhadiran', 'Siswa\Ketidakhadiran::index');
    $routes->get('ketidakhadiran/create', 'Siswa\Ketidakhadiran::create');
    $routes->post('ketidakhadiran/store', 'Siswa\Ketidakhadiran::store');
    $routes->get('ketidakhadiran/edit/(:num)', 'Siswa\Ketidakhadiran::edit/$1');
    $routes->post('ketidakhadiran/update/(:num)', 'Siswa\Ketidakhadiran::update/$1');
    $routes->get('ketidakhadiran/delete/(:num)', 'Siswa\Ketidakhadiran::delete/$1');
});

// Rute untuk Admin
$routes->group('admin', ['filter' => 'adminFilter'], function($routes) {
    $routes->get('ketidakhadiran', 'Admin\Ketidakhadiran::index');
    // Pastikan rute approve menggunakan nama ini
    $routes->get('approve_ketidakhadiran/(:num)', 'Admin\Ketidakhadiran::approve/$1');
});

// Cari bagian ini di Routes.php Anda
$routes->group('siswa', ['filter' => 'siswaFilter'], function($routes) {
    // Route yang sudah ada sebelumnya
    $routes->get('home', 'Siswa\Home::index');
    $routes->get('ketidakhadiran', 'Siswa\Ketidakhadiran::index');
    // ... rute lainnya ...

    // TAMBAHKAN INI (Pastikan case-sensitive-nya benar)
    $routes->get('profil', 'Siswa\Profil::index'); 
    $routes->get('edit_profil', 'Siswa\Profil::edit');
    $routes->post('update_profil', 'Siswa\Profil::update');
    $routes->post('siswa/update_foto', 'Siswa\Profil::update_foto');
    
});