<?php

namespace App\Models;

use CodeIgniter\Model;

class AngsuranModel extends Model
{
    protected $table      = 'angsuran';
    protected $primaryKey = 'id_angsuran';
    protected $allowedFields = [
        'id_pinjam', 
        'angsuran_ke', 
        'tgl_bayar', 
        'bayar_pokok', 
        'bayar_bunga', 
        'total_bayar'
    ];

    public function getPinjamanAktif()
    {
        return $this->db->table('pinjaman p')
            ->select('p.*, a.nama, (SELECT COUNT(*) FROM angsuran WHERE id_pinjam = p.id_pinjaman) as angsuran_ke_skrg')
            ->join('anggota a', 'a.nik_anggota = p.nik_anggota')
            ->where('p.status', 'Belum Lunas')
            ->get()->getResultArray();
    }

    public function getRiwayatAngsuran()
    {
        return $this->select('angsuran.*, anggota.nama, pinjaman.sisa_pinjaman')
                    ->join('pinjaman', 'pinjaman.id_pinjaman = angsuran.id_pinjam')
                    ->join('anggota', 'anggota.nik_anggota = pinjaman.nik_anggota')
                    ->orderBy('angsuran.id_angsuran', 'DESC')
                    ->findAll();
    }

    public function searchAngsuran($keyword)
    {
        return $this->select('angsuran.*, anggota.nama')
                    ->join('pinjaman', 'pinjaman.id_pinjaman = angsuran.id_pinjam')
                    ->join('anggota', 'anggota.nik_anggota = pinjaman.nik_anggota')
                    ->groupStart()
                        ->like('anggota.nama', $keyword)
                        ->orLike('angsuran.id_pinjam', str_replace('P', '', strtoupper($keyword)))
                    ->groupEnd()
                    ->findAll();
    }
}