<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// register
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::registerSave');
// login
$routes->get('/', 'Auth::index');
// $routes->get('/pasien', 'Pasien::index');
$routes->get('/auth', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::loginAuth');
$routes->get('/logout', 'Auth::logout');
$routes->group('pasien', ['filter' => 'role:pasien'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
});
$routes->get('/dashboard', 'Dashboard::index'); //halaman dashboard
$routes->get('/antrian', 'Antrian::index'); //halaman antrian
$routes->post('/antrian/simpan', 'Antrian::simpan'); //menyimpan halaman antrian 
$routes->get('/jadwal', 'Jadwal::index'); //halaman utama jadwal
$routes->post('jadwal/simpan', 'Jadwal::simpan'); //simpan jadwal
$routes->get('/jadwal/reschedule/(:num)', 'Jadwal::reschadyle/$1'); //untuk mengubah status jadi hadir
$routes->get('/riwayat', 'RiwayatPemeriksaan::index'); // menampilkan halaman riwayat pemeriksaan
$routes->get('/profil', 'Pasien::profil'); //menampilkan profil pasien





// halaman dokter

// $routes->get('dashboard', 'Dashboard::index');

$routes->get('/dokter/dashboard', 'Dokter::index');
$routes->get('/dokter/antrian', 'Dokter::antrian');
$routes->get('dokter/periksa/(:num)', 'Dokter::priksa/$1');
$routes->get('/dokter/datapasien', 'Dokter::datapasien');
$routes->get('/dokter/pasienterjadwal', 'Dokter::pasienterjadwal');
$routes->group('dokter', ['filter' => 'role:dokter'], function ($routes) {
    $routes->get('dashboard', 'DashboardDokter::index');
});
$routes->group('dokter', ['filter' => 'role:dokter'], function ($routes) {
    $routes->get('datapasien', 'Dokter::datapasien');
});
$routes->group('dokter', ['filter' => 'role:dokter'], function ($routes) {
    $routes->get('pasienterjadwal', 'Dokter::pasienterjadwal');
});


// role admin
$routes->get('/admin/dashboard', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/antrian', 'Admin::Antrian', ['filter' => 'role:admin']);


$routes->get('/admin/kelolapasien', 'Admin::kelolaPasien', ['filter' => 'role:admin']);
$routes->get('/admin/tambahpasien', 'Admin::tambahPasien', ['filter' => 'role:admin']);
$routes->get('/admin/simpanpasien', 'Admin::simpanPasien', ['filter' => 'role:admin']);
$routes->get('/admin/editpasien/(:num)', 'Admin::editPasien/$1', ['filter' => 'role:admin']);
$routes->get('/admin/updatepasien/(:num)', 'Admin::updatePasien/$1', ['filter' => 'role:admin']);
$routes->get('/admin/hapuspasien/(:num)', 'Admin::hapusPasien/$1', ['filter' => 'role:admin']);
$routes->get('/admin/riwayatpemeriksaanpasien/(:num)', 'Admin::riwayatPemeriksaanPasien/$1', ['filter' => 'role:admin']);

$routes->get('/admin/keloladokter', 'Admin::kelolaDokter', ['filter' => 'role:admin']);
$routes->get('/admin/tambahdokter', 'Admin::tambahDokter', ['filter' => 'role:admin']);
$routes->get('/admin/simpandokter', 'Admin::simpanDokter', ['filter' => 'role:admin']);
$routes->get('/admin/editdokter/(:num)', 'Admin::editDokter/$1', ['filter' => 'role:admin']);
$routes->get('/admin/updatedokter/(:num)', 'Admin::updateDokter/$1', ['filter' => 'role:admin']);
$routes->get('/admin/hapusdokter/(:num)', 'Admin::hapusDokter/$1', ['filter' => 'role:admin']);
