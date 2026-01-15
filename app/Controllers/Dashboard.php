<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Mengambil data untuk Dashboard
        $data = [
            'total_anggota'  => $db->table('anggota')->countAllResults(),
            'total_simpanan' => $db->table('simpanan')->selectSum('jumlah')->get()->getRow()->jumlah ?? 0,
            'total_pinjaman' => $db->table('pinjaman')->selectSum('jumlah_pinjaman')->get()->getRow()->jumlah_pinjaman ?? 0,
        ];

        // Pastikan file view adalah 'dashboard.php' di folder views
        return view('dashboard', $data);
    }

    public function panduan()
    {
        $data['title'] = 'Panduan Admin';
        return view('panduan', $data);
    }
}