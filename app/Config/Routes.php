<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- ROUTE BEBAS AKSES (TANPA LOGIN) ---
$routes->get('login', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// --- ROUTE TERPROTEKSI (WAJIB LOGIN) ---
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // DASHBOARD & PANDUAN
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard/panduan', 'Dashboard::panduan');
    $routes->get('profil', 'Auth::profil');
    $routes->post('profil/update', 'Auth::updateProfil');

    // ANGGOTA
    $routes->get('anggota', 'AnggotaController::anggota'); // Pastikan nama controller konsisten
    $routes->get('anggota/search', 'AnggotaController::search');
    $routes->get('anggota/add', 'AnggotaController::tambah');
    $routes->post('anggota/save', 'AnggotaController::save');
    $routes->post('anggota/update', 'AnggotaController::update');
    $routes->get('anggota/delete/(:num)', 'AnggotaController::delete/$1');

    // SIMPANAN
    $routes->get('simpanan', 'SimpananController::index');
    $routes->post('simpanan/save', 'SimpananController::save');
    $routes->post('simpanan/update', 'SimpananController::update');
    $routes->get('simpanan/delete/(:num)', 'SimpananController::delete/$1');
    $routes->get('simpanan/search', 'SimpananController::search');

    // PINJAMAN
    $routes->get('pinjaman', 'PinjamanController::index');
    $routes->post('pinjaman/save', 'PinjamanController::save');
    $routes->post('pinjaman/update', 'PinjamanController::update');
    $routes->get('pinjaman/delete/(:num)', 'PinjamanController::delete/$1');
    $routes->get('pinjaman/search', 'PinjamanController::search');

    // ANGSURAN
    $routes->get('angsuran', 'Angsuran::index'); 
    $routes->post('angsuran/save', 'Angsuran::save');
    $routes->get('angsuran/search', 'Angsuran::search');
    $routes->get('angsuran/delete/(:num)', 'Angsuran::delete/$1');
});