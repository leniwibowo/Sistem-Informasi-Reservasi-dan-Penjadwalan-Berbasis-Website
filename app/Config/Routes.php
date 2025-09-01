<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// register
$routes->get('/admin/profil', 'Admin::profil',);
$routes->get('/register', 'Auth::register',);
$routes->post('/register', 'Auth::registerSave',);
// login
$routes->get('/', 'Auth::index');
// $routes->get('/pasien', 'Pasien::index');
$routes->get('/auth', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::loginAuth');
$routes->get('/logout', 'Auth::logout');
$routes->get('/profil', 'Pasien::profil');


// routes pasien
$routes->get('pasien/dashboard', 'Pasien::index', ['filter' => 'role:pasien']);
$routes->get('/dashboard', 'Pasien::index', ['filter' => 'role:pasien']); //halaman dashboard
$routes->get('/antrian', 'Antrian::index', ['filter' => 'role:pasien']); //halaman antrian
$routes->post('/antrian/simpan', 'Antrian::simpan', ['filter' => 'role:pasien']); //menyimpan halaman antrian 
$routes->get('/jadwal', 'Jadwal::index', ['filter' => 'role:pasien']); //halaman utama jadwal
$routes->post('jadwal/simpan', 'Jadwal::simpan'); //simpan jadwal
$routes->get('/jadwal/reschedule/(:num)', 'Jadwal::reschadyle/$1'); //untuk mengubah status jadi hadir
$routes->get('/riwayat_pemeriksaan', 'Pasien::RiwayatPemeriksaan');
$routes->get('admin/selesai/(:num)', 'Admin::selesai/$1');
$routes->get('admin/lewati/(:num)', 'Admin::lewati/$1');
$routes->get('admin/profil_pasien/(:num)', 'Admin::profil_pasien/$1');
$routes->get('admin/api/dokter_by_jadwal', 'Admin::apiGetDokterByJadwal');
// Untuk menampilkan halaman form
$routes->get('admin/jadwal/tambah/(:num)', 'Admin::tambahJadwalPasien/$1');
// Untuk MENYIMPAN data dari form
$routes->post('admin/jadwal/tambah/(:num)', 'Admin::tambahJadwalPasien/$1');

// // Rute untuk menampilkan form edit pasien spesifik (dengan ID)

// $routes->get('/pasien', 'Pasien::pasien');
// // Rute POST untuk update
// $routes->post('pasien/up'Pasien::update/$1');date/(:num)', 
// // halaman dokter

// $routes->get('dashboard', 'Dashboard::index');

$routes->get('/dokter/dashboard', 'Dokter::index');
$routes->get('/dokter/antrian', 'Dokter::antrian');
$routes->get('dokter/pemeriksaan/(:num)', 'Dokter::pemeriksaan/$1');
$routes->post('dokter/pemeriksaan/(:num)', 'Dokter::simpanPemeriksaan/$1');
$routes->get('dokter/riwayatpemeriksaan/(:num)', 'Dokter::riwayatPemeriksaanPasien/$1');
$routes->get('/dokter/datapasien', 'Dokter::datapasien');
$routes->get('/dokter/pasienterjadwal', 'Dokter::pasienterjadwal');
$routes->get('/dokter/profil', 'Dokter::profil');



// role admin
$routes->get('/admin/dashboard', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/antrian', 'Admin::Antrian', ['filter' => 'role:admin']);
$routes->get('/admin/profil', 'Admin::profil', ['filter' => 'role:admin']);


// kelola pasien
$routes->get('/admin/tambahpasien', 'Admin::tambahPasien', ['filter' => 'role:admin']);
$routes->get('admin/download', 'Admin::download');



$routes->get('/admin/editpasien/(:num)', 'Admin::editPasien/$1', ['filter' => 'role:admin']);
$routes->get('/admin/updatepasien/(:num)', 'Admin::updatePasien/$1', ['filter' => 'role:admin']);
$routes->post('/admin/updatepasien/(:num)', 'Admin::updatePasien/$1', ['filter' => 'role:admin']);
$routes->get('/admin/hapuspasien/(:num)', 'Admin::hapusPasien/$1', ['filter' => 'role:admin']);
$routes->get('/admin/riwayatpemeriksaan/(:num)', 'Admin::riwayatPemeriksaanPasien/$1', ['filter' => 'role:admin']);
$routes->get('admin/antrian/lewati/(:num)', 'Admin::lewati/$1');
// kelola dokter
$routes->get('/admin/keloladokter', 'Admin::kelolaDokter', ['filter' => 'role:admin']);
$routes->get('admin/tambahdokter', 'Admin::tambahDokter', ['filter' => 'role:admin']);
$routes->post('admin/simpandokter', 'Admin::simpanDokter', ['filter' => 'role:admin']);
$routes->get('/admin/editdokter/(:num)', 'Admin::editDokter/$1', ['filter' => 'role:admin']);
$routes->get('/admin/updatedokter/(:num)', 'Admin::updateDokter/$1', ['filter' => 'role:admin']);
$routes->post('/admin/updatedokter/(:num)', 'Admin::updateDokter/$1', ['filter' => 'role:admin']);
$routes->get('/admin/hapusdokter/(:num)', 'Admin::hapusDokter/$1', ['filter' => 'role:admin']);

// kelola admin
$routes->get('/admin/kelolaadmin', 'Admin::kelolaAdmin', ['filter' => 'role:admin']);
$routes->get('admin/tambahadmin', 'Admin::tambahAdmin', ['filter' => 'role:admin']);
$routes->post('admin/simpanadmin', 'Admin::simpanAdmin', ['filter' => 'role:admin']);
$routes->get('/admin/editadmin/(:num)', 'Admin::editAdmin/$1', ['filter' => 'role:admin']);
$routes->get('/admin/updateadmin/(:num)', 'Admin::updateAdmin/$1', ['filter' => 'role:admin']);
$routes->post('/admin/updateadmin/(:num)', 'Admin::updateAdmin/$1', ['filter' => 'role:admin']);
$routes->get('/admin/hapusadmin/(:num)', 'Admin::hapusAdmin/$1', ['filter' => 'role:admin']);
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('periksa/(:num)', 'Admin::periksa/$1');
    $routes->get('selesai/(:num)', 'Admin::selesai/$1');
    $routes->get('lewati/(:num)', 'Admin::lewati/$1');
});
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('kelolapasien', 'Admin::kelolaPasien');
    $routes->post('simpanPasien', 'Admin::simpanPasien');
});


// halaman pasien terjadwal
$routes->get('/admin/pasienterjadwal', 'Admin::pasienTerjadwal');
$routes->get('/admin/tambahJadwalPasien/(:num)', 'Admin::tambahJadwalPasien/$1');
$routes->post('/admin/simpanJadwalPasien/(:num)', 'Admin::simpanJadwalPasien/$1');


// Rute untuk menampilkan form percobaan
$routes->get('admin/jadwal_percobaan', 'Admin::jadwalPercobaan');
// Rute untuk memproses data dari form percobaan
$routes->post('admin/simpan_jadwal_percobaan', 'Admin::simpanJadwalPercobaan');
// Rute API untuk mendapatkan daftar pasien
$routes->get('admin/api/get_all_pasien', 'Admin::apiGetAllPasien');


$routes->get('auth/lupa-password', 'Auth::forgotPasswordForm');
$routes->post('auth/lupa-password', 'Auth::processForgotPassword');
$routes->get('reset-password/(:any)', 'Auth::resetPasswordForm/$1');
$routes->post('reset-password', 'Auth::updatePassword');

$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('kelolajadwal', 'Admin::kelolaJadwalDokter');
    $routes->post('jadwal-dokter/simpan', 'Admin::simpanJadwalDokter');
    $routes->get('jadwal-dokter/hapus/(:num)', 'Admin::hapusJadwalDokter/$1');
});
