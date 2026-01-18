<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StatistikModel; // Import Modelnya

class Dashboard extends BaseController
{
    public function index()
    {
        // Inisialisasi Model
        $statistikModel = new StatistikModel();

        // Mengambil data melalui fungsi yang ada di Model
        $data = [
            'total_anggota'  => $statistikModel->get_total_anggota(),
            'total_simpanan' => $statistikModel->get_total_simpanan(),
            'total_pinjaman' => $statistikModel->get_total_pinjaman(),
        ];

        return view('dashboard', $data);
    }

    public function panduan()
    {
        $data['title'] = 'Panduan Admin';
        return view('panduan', $data);
    }
}