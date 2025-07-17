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
$routes->get('dokter/priksa/(:num)', 'Dokter::priksa/$1');
$routes->get('/dokter/datapasien', 'Dokter::datapasien');
$routes->get('/dokter/pasienterjadwal', 'Dokter::pasienterjadwal');

// halaman utama jadwal

// 

// untuk tombol reschedule

// untuk mengubah status jadi hadir
