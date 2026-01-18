<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table      = 'admin';
    protected $primaryKey = 'id_petugas';
    
    // Kolom yang diizinkan untuk diubah (untuk update profil)
    protected $allowedFields = ['username', 'password'];

    /**
     * Cari admin berdasarkan username
     */
    public function cekLogin($username)
    {
        return $this->where('username', $username)->first();
    }
}