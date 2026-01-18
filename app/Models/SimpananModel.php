<?php

namespace App\Models;

use CodeIgniter\Model;

class SimpananModel extends Model
{
    protected $table            = 'simpanan';
    protected $primaryKey       = 'id_simpanan';
    protected $allowedFields    = ['nik_anggota', 'jenis_simpanan', 'jumlah', 'tgl_setor'];

    public function getSimpananWithAnggota($keyword = null)
    {
        $builder = $this->select('simpanan.*, anggota.nama')
                        ->join('anggota', 'anggota.nik_anggota = simpanan.nik_anggota');

        if ($keyword) {
            $builder->groupStart()
                        ->like('anggota.nama', $keyword)
                        ->orLike('simpanan.nik_anggota', $keyword)
                    ->groupEnd();
        }
        return $builder->orderBy('simpanan.id_simpanan', 'DESC')->findAll();
    }
}