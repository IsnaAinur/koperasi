<?php

namespace App\Models;

use CodeIgniter\Model;

class PinjamanModel extends Model
{
    protected $table            = 'pinjaman';
    protected $primaryKey       = 'id_pinjaman';
    protected $allowedFields    = ['nik_anggota', 'jumlah_pinjaman', 'tenor', 'bunga', 'status', 'sisa_pinjaman'];

    // Menampilkan semua pinjaman
    public function getAllPinjaman()
    {
        return $this->select('pinjaman.*, anggota.nama')
                    ->join('anggota', 'anggota.nik_anggota = pinjaman.nik_anggota')
                    ->findAll();
    }

    //mencari pinjaman berdasarkan nama
    public function searchPinjaman($keyword)
    {
        return $this->select('pinjaman.*, anggota.nama')
                    ->join('anggota', 'anggota.nik_anggota = pinjaman.nik_anggota')
                    ->groupStart()
                        ->like('anggota.nama', $keyword)
                        ->orLike('pinjaman.id_pinjaman', str_replace('PJN-', '', $keyword))
                    ->groupEnd()
                    ->findAll();
    }
}