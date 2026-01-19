<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table            = 'anggota';
    protected $primaryKey       = 'nik_anggota';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['nik_anggota', 'nama', 'alamat', 'no_hp', 'tgl_bergabung'];

    //fungsi untuk pencarian anggota
    public function search($keyword)
    {
        return $this->like('nama', $keyword)
                    ->orLike('alamat', $keyword)
                    ->orLike('nik_anggota', $keyword)
                    ->findAll();
    }
}