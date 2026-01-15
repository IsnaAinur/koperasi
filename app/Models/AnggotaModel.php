<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table      = 'anggota';
    protected $primaryKey = 'nik_anggota';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['nik_anggota','nama', 'alamat', 'no_hp', 'tgl_bergabung'];

    public function search($keyword)
    {
        // Mencari berdasarkan nama atau alamat
        return $this->table('anggota')
                    ->like('nama', $keyword)
                    ->orLike('alamat', $keyword)
                    ->findAll();
    }
}