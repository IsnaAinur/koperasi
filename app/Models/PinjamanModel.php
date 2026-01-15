<?php

namespace App\Models;

use CodeIgniter\Model;

class PinjamanModel extends Model
{
    protected $table            = 'pinjaman';
    protected $primaryKey       = 'id_pinjaman';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nik_anggota', 
        'jumlah_pinjaman', 
        'tenor', 
        'bunga', 
        'status', 
        'sisa_pinjaman'
    ];
}